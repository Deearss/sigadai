# TASK-14: Hardening CI/CD

**Status:** ✅ Selesai
**Prasyarat:** TASK-13 ✅ (biar nggak nyampur sama perubahan app)
**Asal:** temuan review keamanan 2026-07-15

## Konteks temuan

[.github/workflows/deploy.yml:14](../../.github/workflows/deploy.yml) pakai `appleboy/ssh-action@v1.0.3` — itu **git tag yang mutable**, dan action ini dikasih `secrets.VPS_SSH_KEY` (private key full akses VPS). Kalau repo action-nya dikompromi dan tag-nya di-repoint ke commit jahat, run deploy berikutnya bisa eksfiltrasi private key → attacker dapet shell ke VPS. Ini vektor supply-chain yang sama persis dengan insiden `tj-actions/changed-files` (CVE-2025-30066, Maret 2025).

## Instruksi

1. Ambil commit SHA dari tag v1.0.3:
   ```bash
   git ls-remote https://github.com/appleboy/ssh-action refs/tags/v1.0.3
   ```
2. Ganti di deploy.yml:
   ```yaml
   uses: appleboy/ssh-action@<40-char-sha>  # v1.0.3
   ```
3. Tambahin guard biar dua push beruntun nggak deploy tabrakan (git pull + composer barengan di server = kondisi aneh):
   ```yaml
   concurrency:
     group: deploy-production
     cancel-in-progress: false
   ```
   (di level job atau workflow.)

## Kriteria selesai

- [x] deploy.yml nggak ada lagi referensi action via tag mutable
- [x] Push → run Actions hijau → situs live tetap jalan normal (buka dashboard, login demo)
- [x] Push dua commit beruntun cepat → deploy jalan berurutan, nggak paralel (cek tab Actions)

## Jangan

- Jangan ganti action lain / rombak workflow. Minimal-diff.
- Jangan pernah nge-print secrets di script step (walau buat debug).

## Commit

`TASK-14: pin ssh-action ke commit SHA + concurrency guard deploy`
