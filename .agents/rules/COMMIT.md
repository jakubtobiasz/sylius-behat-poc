# COMMIT.md — Git commit rules

Agent rules for creating commits in this repository.

## Message format

- **No Conventional Commits prefixes** — do not use `feat:`, `fix:`, `chore:`, etc.
- **Subject starts with an uppercase letter.**
- One short subject line (≤ 72 characters); add a body only when the *why* is not obvious from the subject.
- Write complete sentences with good grammar.
- Focus on *why*, not a file list.

```text
Bootstrap Sylius Behat package on Playwright

Replace Sylius\Behat with Alphpaca-owned contexts, pages, and a
Playwright Mink driver wired through a Behat extension.
```

Not:

```text
feat: bootstrap sylius behat package on playwright
```

## When to commit

- Commit **only when the user explicitly asks**.
- If intent is unclear, ask first.

## What to stage

- Stage **only** files that belong to the current task.
- Exclude unrelated changes, generated artifacts (`vendor/`, `composer.lock`), and local-only config unless the task requires them.
- Never stage secrets (`.env`, credentials, tokens).

## Safety

- Do **not** push unless the user explicitly asks.
- Do **not** run destructive git commands (`push --force`, `reset --hard`, etc.) unless explicitly requested.
- Do **not** skip hooks (`--no-verify`) unless explicitly requested.
- Do **not** amend unless the user asks, or a hook auto-modified files after a successful commit you just created (unpushed).

## Workflow

1. Run `git status`, `git diff`, and `git log` to understand state and message style.
2. Stage relevant paths only.
3. Commit with a HEREDOC message:

```bash
git commit -m "$(cat <<'EOF'
Subject line here

Optional body when why is not obvious.
EOF
)"
```

4. Run `git status` after commit to confirm success.
