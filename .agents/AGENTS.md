# Agent Rules for Storyloom

- **Backend-Driven Text Changes**: Whenever the user requests text or copy changes, always make the change in the relevant place in the backend/dashboard (e.g. database seeds, CMS models, settings tables, or backend controller defaults) in addition to frontend templates, so changes persist and do not revert when content is updated via the backend.
- **Production Environment Root Path**: On cPanel production server, the website root directory is `~/storyloombooks.com` (e.g. run `cd ~/storyloombooks.com && php artisan cache:clear`).
- **Commit Message Requirement**: At the end of every task/response involving code or file changes, provide a concise one-line commit message suitable for Git / Sublime Merge.

