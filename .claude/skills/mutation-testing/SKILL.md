---
name: mutation-testing
argument-hint: <path-to-test-file-or-directory>
description: Use when tests have been written and need verification that they actually catch real bugs — after write-automated-tests completes, or when auditing existing test quality.
---

# Mutation Testing (Laravel / PHPUnit)

## Overview

Apply deliberate code mutations to production source files, run tests after each, and report which mutants **survived** (tests passed despite broken code). Survivors reveal assertions that are missing or too weak.

**No framework needed** — uses Edit, Bash, and Read directly.

## Workflow

### 1. Identify test files to target

**If `$ARGUMENTS` is provided:** use those paths directly.

**If `$ARGUMENTS` is empty:** discover candidates automatically:
1. Run `git diff --name-only HEAD` — prefer recently modified test files
2. If nothing recent, glob `tests/Feature/` and `tests/Unit/` for all `*Test.php` files
3. Present the list and ask the user to confirm which files to target before proceeding

Then read the confirmed test file(s) and extract every production class exercised (controllers, services, models). Only mutate those files — never test files, factories, or migrations.

### 2. List mutation candidates
Read each source file. For every mutation-eligible line, assign a sequential ID (M-01, M-02…). Note the exact `old_string` you will use with Edit.

### 3. Run the baseline
```bash
./vendor/bin/sail php vendor/bin/phpunit $ARGUMENTS
```
All tests must pass before starting. If any fail, stop — mutation results would be meaningless.

### 4. Mutate → Test → Revert (one at a time)

For each candidate:

**a. Apply mutation**
Use the `Edit` tool: replace `old_string` with the mutated `new_string`.

**b. Run tests**
```bash
./vendor/bin/sail php vendor/bin/phpunit $ARGUMENTS
```

**c. Record result**
- **KILLED** — at least one test failed. Note which test method(s).
- **SURVIVED** — all tests passed. This is a gap.

**d. Revert immediately**
Use `Edit` again: restore `new_string` → `old_string`.

**e. Verify revert before continuing**
Read the relevant lines of the source file to confirm the original code is restored. Never proceed with the next mutation until revert is confirmed.

> If the test run hangs or produces an unexpected error, revert and mark the candidate **INCONCLUSIVE**.

### 5. Produce mutation report

```markdown
## Mutation Report

| ID | File | Mutation Applied | Result | Killed By |
|----|------|-----------------|--------|-----------|
| M-01 | RegisterController.php | `route('dashboard')` → `route('login')` | KILLED | test_R01_redirects_to_dashboard_after_registration |
| M-02 | ShippingAddressController.php | `abort_if(...)` → `abort_unless(...)` | SURVIVED | — |
```

### 6. Summarize

```
Mutations attempted : N
Killed             : K  (K/N %)
Survived           : S
Inconclusive       : I

Surviving mutants (assertions to add):
- M-02: ShippingAddressController line 26 — no test verifies the 403 is triggered by ownership check
```

### 7. Write the report to disk

Get the current timestamp:
```bash
date +"%Y%m%d_%H%M%S"
```

Derive the filename from the target test file — strip the path and `.php` extension, append the timestamp:
- Target: `tests/Feature/Auth/RegistrationTest.php` → filename: `RegistrationTest_20260324_161500.md`

Write the full report (table + summary from steps 5–6) to:
```
docs/reports/<filename>.md
```

Create the `docs/reports/` directory first if it does not exist:
```bash
mkdir -p docs/reports
```

---

## Mutation Operators (apply in priority order)

| Priority | Operator | Example |
|----------|----------|---------|
| 1 | Negate return boolean | `return true` → `return false` |
| 2 | Negate abort condition | `abort_if($x, 403)` → `abort_unless($x, 403)` |
| 3 | Flip comparison | `!==` → `===`, `>` → `>=`, `<` → `<=` |
| 4 | Flip logical operator | `&&` → `||` |
| 5 | Change session flash value | `->with('status', 'foo')` → `->with('status', 'bar')` |
| 6 | Change redirect route | `route('dashboard')` → `route('login')` in a redirect |
| 7 | Negate Hash::check | `!Hash::check(...)` → `Hash::check(...)` |

Focus on priority 1–4 first. Apply higher-priority operators exhaustively before moving to lower ones.

---

## Safety Rules

- **Never** start the next mutation before reverting the current one
- **Never** mutate test files, factories, migrations, or config
- **Always** read the mutated lines after reverting to confirm the restore succeeded
- One mutation per Edit call — do not batch multiple changes

---

## Common Mistakes

| Mistake | Fix |
|---------|-----|
| Mutating untested code | Check test imports — only mutate exercised files |
| Forgetting to revert | Always call Edit to restore before the next candidate |
| Marking survived = bad test suite | Some survivors are legitimate (unreachable branches) — note why |
| Running the full suite instead of the relevant tests | Faster feedback; only run tests that exercise the mutated file |
