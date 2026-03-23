# Feature: [Product]

## Goal
This is the bread and butter feature for the project, here we add products to be sold

## Requirements
- [ ] Create product model, policy, controller, factory, migration (and possibly something else I forgot)
- [ ] Create an admin section where only super admin and product admins can add, edit and delete products
- [ ] Create admin user interface for prodct management
- [ ] Create public views for regular users

## Out of scope
- Product viw should have a add to cart button but without any action taking place for a while
- We're adding a cart feature but it's out of scope for now
- Similar to cart, we're allso adding a Category system in the next iterations
- And an image galley

## Data model
Product should have its own products table with title, slug, description, short description, price, images

## Routes
| Method | URI | Description |
|--------|-----|-------------|
| GET    | /admin/products | products list |
| GET    | /admin/products/create | product create form |
| GET    | /admin/products/{product-slug} | product view |
| GET    | /admin/products/{product-slug}/edit | product view |
| GET    | /products | lists all products |
| GET    | /products/{product-slug} | product view |

## UI / UX
Admin section can keep current look and fell
Public endpoints should be what we usually expect, we'll improve it in future iterations

## Roles & permissions
Create an admin section where only super admin and product admins can add, edit and delete products.
Regular users can see product and list view

