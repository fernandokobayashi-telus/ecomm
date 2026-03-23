# Test Cases: User Feature

Covers authentication, registration, profile management, shipping addresses, and admin user management.

---

## 1. Registration

| # | Description | Input | Expected |
|---|---|---|---|
| R-01 | Successful registration | Valid name, email, password + confirmation | User created with `role = user`; redirected to dashboard; logged in |
| R-02 | Duplicate email | Email already in `users` table | Validation error on `email` field |
| R-03 | Password too short | Password with 7 characters | Validation error: min 8 characters |
| R-04 | Password confirmation mismatch | `password` ≠ `password_confirmation` | Validation error on `password` |
| R-05 | Missing required fields | Empty name or email | Validation errors on missing fields |
| R-06 | Already authenticated | Logged-in user visits `/register` | Redirected away (guest middleware) |

---

## 2. Login

| # | Description | Input | Expected |
|---|---|---|---|
| L-01 | Successful login | Correct email + password | Session created; redirected to dashboard |
| L-02 | Wrong password | Correct email, wrong password | Error on `email` field: "credentials do not match" |
| L-03 | Non-existent email | Email not in database | Error on `email` field |
| L-04 | Remember me | `remember = true` | Remember-me cookie set |
| L-05 | Already authenticated | Logged-in user visits `/login` | Redirected away (guest middleware) |

---

## 3. Logout

| # | Description | Input | Expected |
|---|---|---|---|
| LO-01 | Successful logout | POST `/logout` while authenticated | Session invalidated; CSRF token regenerated; redirected to `/login` |
| LO-02 | Unauthenticated logout attempt | POST `/logout` without session | Redirected to login (auth middleware) |

---

## 4. Profile Update

| # | Description | Input | Expected |
|---|---|---|---|
| P-01 | Update name | New valid name | `users.name` updated; redirected to `dashboard#profile` with `status = profile-updated` |
| P-02 | Update phone number | Valid phone string (digits, spaces, `+`, `-`, `(`, `)`) | `users.phone_number` updated |
| P-03 | Clear phone number | Empty phone field | `phone_number` set to null |
| P-04 | Invalid phone format | Letters in phone number | Validation error on `phone_number` |
| P-05 | Phone too long | Phone string > 20 chars | Validation error |
| P-06 | Name required | Empty name | Validation error on `name` |
| P-07 | Unauthenticated | Not logged in | Redirected to login |

---

## 5. Password Change

| # | Description | Input | Expected |
|---|---|---|---|
| PW-01 | Successful password change | Correct current password, new password + confirmation | Password updated; redirected to `dashboard#password` with `status = password-updated` |
| PW-02 | Wrong current password | Incorrect current password | Error on `current_password`; password unchanged |
| PW-03 | New password too short | New password < 8 characters | Validation error |
| PW-04 | Confirmation mismatch | `password` ≠ `password_confirmation` | Validation error |
| PW-05 | Unauthenticated | Not logged in | Redirected to login |

---

## 6. Shipping Addresses — Create

| # | Description | Input | Expected |
|---|---|---|---|
| A-01 | Add address (no default) | Valid fields, `is_default = false` | Address created; redirected to `dashboard#addresses` with `status = address-added` |
| A-02 | Add address as default | `is_default = true` | All other user addresses set to `is_default = false`; new address is default |
| A-03 | Missing required fields | Empty `recipient_name`, `address_line_1`, `city`, `state`, `zip`, or `country` | Validation errors on each missing field |
| A-04 | Country not 2 chars | `country = "USA"` | Validation error (`size:2`) |
| A-05 | Unauthenticated | Not logged in | Redirected to login |

---

## 7. Shipping Addresses — Update

| # | Description | Input | Expected |
|---|---|---|---|
| A-06 | Update own address | Valid data for own address | Address updated; redirected to `dashboard#addresses` with `status = address-updated` |
| A-07 | Set own address as default | `is_default = true` | Other user addresses lose default; this address becomes default |
| A-08 | Update another user's address | Address belongs to different user | 403 Forbidden |
| A-09 | Unauthenticated | Not logged in | Redirected to login |

---

## 8. Shipping Addresses — Delete

| # | Description | Input | Expected |
|---|---|---|---|
| A-10 | Delete own address | Own address ID | Address removed; redirected to `dashboard#addresses` with `status = address-deleted` |
| A-11 | Delete another user's address | Address belongs to different user | 403 Forbidden |
| A-12 | Unauthenticated | Not logged in | Redirected to login |

---

## 9. Admin — User List

| # | Description | Input | Expected |
|---|---|---|---|
| AU-01 | Super admin can view list | Authenticated as `super_admin` | 200 OK; all users listed |
| AU-02 | Regular user blocked | Authenticated as `user` | 403 Forbidden |
| AU-03 | Product admin blocked | Authenticated as `product_admin` | 403 Forbidden |
| AU-04 | Unauthenticated | Not logged in | Redirected to login |

---

## 10. Admin — Edit User

| # | Description | Input | Expected |
|---|---|---|---|
| AU-05 | Super admin can edit any user | Valid name, email, role | User record updated; redirected to users list with `status = user-updated` |
| AU-06 | Change user role | New valid `UserRole` value | `users.role` updated |
| AU-07 | Duplicate email | Email already taken by another user | Validation error on `email` |
| AU-08 | Own email excluded from uniqueness check | Super admin updates their own email to same value | No validation error |
| AU-09 | Invalid role value | `role = "invalid_role"` | Validation error |
| AU-10 | Non-super-admin blocked | Authenticated as `product_admin` | 403 Forbidden |

---

## 11. Admin — Delete User

| # | Description | Input | Expected |
|---|---|---|---|
| AU-11 | Delete another user | Any user other than self | User deleted; redirected to users list with `status = user-deleted` |
| AU-12 | Self-delete prevention | Super admin tries to delete their own account | Error returned: "You cannot delete your own account."; user not deleted |
| AU-13 | Non-super-admin blocked | Authenticated as `user` or `product_admin` | 403 Forbidden |
