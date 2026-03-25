---
name: write-automated-tests
argument-hint: <path-to-test-cases-file>
description: Writes automated tests based on reference test case markdown file and creates a report linking every test to its test case.
---

# Write Automated Tests (Laravel / PHPUnit)

## Overview

Read the application source before writing a single test. 

Tests must reflect actual behaviour not assumed behaviour.

Never change any of the test cases.

Be explicit when not able to write an automated test for a test case.

The spec file is: `$ARGUMENTS`

## Workflow

### 1. Read the spec
Read `$ARGUMENTS`. Understand what each case asserts: input, expected HTTP status, DB change, session flash, redirect target.

### 2. Read the source — before touching tests
For each feature under test, read:
- **Routes** (`routes/web.php`) — HTTP method, URI, named route, middleware
- **Controller** — validation rules, redirect URLs, session keys, abort conditions
- **Model & Factory** — fillable fields, casts, factory states
- **Enum** — valid values for role/status fields
- **Migrations** — column names and nullability

### 3. One test file per feature area
Match the spec's section structure. Name files after the feature, not the controller.

### 4. One test method per distinct assertion
Split a single spec case into multiple methods when HTTP status, DB state, session flash, or auth state each need a separate assertion. Prefix method names with the spec ID (e.g. `test_R01_*`).

### 5. Use named routes, not hardcoded URIs
```php
// ✅
$this->post(route('addresses.store'), $payload);

// ❌
$this->post('/addresses', $payload);
```

### 6. Prefer factory states over inline attribute arrays
```php
// ✅
$admin = User::factory()->superAdmin()->create();

// ❌
$admin = User::factory()->create(['role' => 'super_admin']);
```

### 7. Helper method for repeated payloads
Define a `validPayload(array $overrides = [])` private method in each test class. Override only the field under test per case — keeps each test minimal and readable.

### 8. Separate happy-path from guard tests
Group tests with comments matching the spec sections. Test role-based 403s and unauthenticated redirects as distinct methods, not combined with the happy path.

### 9. Run the tests
Run the test suite and fix any failures before proceeding to the report.

> 💡 Once all tests pass, consider running the `mutation-testing` skill to verify the tests actually catch real bugs.

### 10. Write the traceability report
Produce a report next to the spec file (e.g. `[feature-name]-traceability-report.md`) with:
- A table per spec section mapping each spec ID to its test method(s)
- A summary table: spec cases count vs automated tests count
- Explicit list of any spec cases that could not be automated, with reason

## Assertions Cheat Sheet

| What to assert | Method |
|---|---|
| Record exists in DB | `assertDatabaseHas('table', [...])` |
| Record removed from DB | `assertDatabaseMissing('table', [...])` |
| Redirected to named route | `assertRedirect(route('name'))` |
| Redirected with fragment | `assertRedirect(route('name') . '#fragment')` |
| Session flash value | `assertSessionHas('status', 'value')` |
| Validation error on field | `assertSessionHasErrors('field')` |
| 403 response | `assertForbidden()` |
| 200 response | `assertOk()` |
| User is authenticated | `assertAuthenticated()` / `assertAuthenticatedAs($user)` |
| User is guest | `assertGuest()` |

## Common Mistakes

| Mistake | Fix |
|---|---|
| Writing tests before reading the controller | Always read validation rules and redirect targets first |
| Hardcoded URLs | Use named routes |
| One giant test method per spec case | Split into focused single-assertion methods |
| Guessing session/flash keys | Read the controller's `->with('key', 'value')` call |
| Missing unauthenticated guard tests | Every mutating route needs an unauthenticated test |
