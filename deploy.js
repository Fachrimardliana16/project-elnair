/**
 * deploy.js — Local FTP Deploy Script
 * Usage: node deploy.js
 *
 * Requires: npm install basic-ftp dotenv --save-dev
 *
 * Structure:
 *   Local ./          → FTP elnair/          (Laravel root)
 *   Local ./public/   → FTP public_html/elnair/  (Web root)
 */

import * as ftp from 'basic-ftp';
import * as fs from 'fs';
import * as path from 'path';
import { fileURLToPath } from 'url';
import { readFileSync } from 'fs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

// Load .deploy.env manually (avoid adding dotenv to prod deps)
function loadEnv(file) {
    const content = readFileSync(file, 'utf-8');
    for (const line of content.split('\n')) {
        const trimmed = line.trim();
        if (!trimmed || trimmed.startsWith('#')) continue;
        const [key, ...rest] = trimmed.split('=');
        process.env[key.trim()] = rest.join('=').trim();
    }
}
loadEnv(path.join(__dirname, '.deploy.env'));

// Files/folders to SKIP when uploading Laravel root
const EXCLUDE_LARAVEL = new Set([
    '.git', '.github', 'node_modules', '.env', '.env.backup',
    '.env.production', '.env.example', 'public', 'vendor',
    '.deploy.env', '.gitignore', '.editorconfig', 'README.md',
    '.ftp-deploy-sync-state-laravel.json',
    '.ftp-deploy-sync-state-public.json',
    'deploy.js', '.DS_Store', 'Thumbs.db',
]);

// Files/folders to SKIP when uploading public/
const EXCLUDE_PUBLIC = new Set([
    '.DS_Store', 'Thumbs.db', 'hot', 'storage',
]);

const FTP_CONFIG = {
    host: process.env.FTP_SERVER,
    user: process.env.FTP_USERNAME,
    password: process.env.FTP_PASSWORD,
    port: parseInt(process.env.FTP_PORT || '21'),
    secure: false,
};

async function uploadDir(client, localDir, remoteDir, excludeSet) {
    const entries = fs.readdirSync(localDir, { withFileTypes: true });

    for (const entry of entries) {
        if (excludeSet.has(entry.name)) continue;

        const localPath = path.join(localDir, entry.name);
        const remotePath = `${remoteDir}/${entry.name}`;

        if (entry.isDirectory()) {
            try { await client.ensureDir(remotePath); } catch {}
            await uploadDir(client, localPath, remotePath, excludeSet);
            // Return to parent dir after recursing
            await client.cd(remoteDir);
        } else {
            process.stdout.write(`  uploading ${remotePath.replace(remoteDir.split('/')[0] + '/', '')}\n`);
            await client.uploadFrom(localPath, remotePath);
        }
    }
}

async function deploy() {
    const client = new ftp.Client();
    client.ftp.verbose = false;

    try {
        await client.access(FTP_CONFIG);
        console.log('✅ Connected to FTP server\n');

        // ── Step 1: Deploy Laravel project → elnair/ ───────────────────
        console.log('📦 Deploying Laravel project → elnair/');
        await client.ensureDir('elnair');
        await uploadDir(client, __dirname, 'elnair', EXCLUDE_LARAVEL);
        console.log('✅ Laravel project uploaded\n');

        // ── Step 2: Deploy public/ → public_html/elnair/ ───────────────
        console.log('🌐 Deploying public/ → public_html/elnair/');
        await client.ensureDir('public_html/elnair');
        await uploadDir(client, path.join(__dirname, 'public'), 'public_html/elnair', EXCLUDE_PUBLIC);
        console.log('✅ Public folder uploaded\n');

        console.log('🚀 Deployment complete!');
        console.log('👉 Open deploy-runner.php to run migrations & cache clear');

    } catch (err) {
        console.error('❌ Deploy failed:', err.message);
        process.exit(1);
    } finally {
        client.close();
    }
}

deploy();
