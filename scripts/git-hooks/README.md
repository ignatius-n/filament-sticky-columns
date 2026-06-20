# Git hooks

Copy into your local `.git/hooks/` after clone:

```bash
cp scripts/git-hooks/prepare-commit-msg .git/hooks/prepare-commit-msg
chmod +x .git/hooks/prepare-commit-msg
```

Removes `Co-authored-by: Cursor` and `Made-with: Cursor` from commit messages.

Also disable **Cursor Settings → Agents → Attribution → Commit Attribution**.
