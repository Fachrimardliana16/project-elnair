/**
 * deploy-targeted.js — Upload only specific changed files
 * Usage: node deploy-targeted.js
 */
import * as ftp from 'basic-ftp';
import * as path from 'path';
import { fileURLToPath } from 'url';
import { readFileSync, readdirSync } from 'fs';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

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

const FTP_CONFIG = {
    host: process.env.FTP_SERVER,
    user: process.env.FTP_USERNAME,
    password: process.env.FTP_PASSWORD,
    port: parseInt(process.env.FTP_PORT || '21'),
    secure: false,
};

// [local path relative to project root, remote FTP path]
const FILES = [
    // Blade layout (self-hosted fonts + no more Google Fonts external)
    ['resources/views/landing/layouts/app.blade.php',
     'elnair/resources/views/landing/layouts/app.blade.php'],
    // PHP-FPM gzip via zlib
    ['public/.user.ini',
     'public_html/elnair/.user.ini'],
];

// Self-hosted font files
const FONTS_LOCAL = path.join(__dirname, 'public/assets/fonts');
const FONTS_REMOTE = 'public_html/elnair/assets/fonts';
const fontFiles = readdirSync(FONTS_LOCAL).filter(f => f.endsWith('.woff2'));
for (const f of fontFiles) {
    FILES.push([`public/assets/fonts/${f}`, `${FONTS_REMOTE}/${f}`]);
}

async function deploy() {
    const client = new ftp.Client();
    client.ftp.verbose = false;

    try {
        await client.access(FTP_CONFIG);
        console.log('✅ Connected to FTP\n');

        // Ensure font dir exists
        await client.ensureDir(FONTS_REMOTE);
        await client.cd('/');

        for (const [local, remote] of FILES) {
            const localPath = path.join(__dirname, local);
            const remoteDir = remote.substring(0, remote.lastIndexOf('/'));
            await client.ensureDir(remoteDir);
            await client.cd('/');
            console.log(`  ⬆  ${remote}`);
            await client.uploadFrom(localPath, remote);
        }

        console.log('\n✅ All files uploaded!');
        console.log('👉 Run clear-cache: https://elnair.chillfile.my.id/clear-cache.php?token=20850ba12d0f486dac9a913a0da2db237cc1ef622e6fd4cc');
    } catch (err) {
        console.error('❌ Deploy failed:', err.message);
        process.exit(1);
    } finally {
        client.close();
    }
}

deploy();
