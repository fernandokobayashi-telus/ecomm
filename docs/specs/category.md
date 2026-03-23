# Feature: [Categories]

## Goal
Categories to help organizing similar products together

## Requirements
- [ ] Category Entities created
- [ ] Category admin section created, with CRUD operations
- [ ] Category relationship added to products
- [ ] Product form updated to list all categories
- [ ] Category can be seen i nproduct view page
- [ ] Category public pages where users can sort products by categories
- [ ] One product can belong to multiple categories

## Out of scope


## Data model
One main category allowing up to 2 levels of child categories
Category has a title and a slug
Category can be deleted, all products of said category will have it removed from the list of categories from that product


## Routes
| Method | URI | Description |
|--------|-----|-------------|
| GET    | /admin/categories | categories list |
| GET    | /admin/categories/create | product create form |
| GET    | /admin/categories/{category-slug} | category view |
| GET    | /admin/categories/{category-slug}/edit | category view |
| GET    | /categories | lists all categories |
| GET    | /categories/{category-slug} | lists all products from that category |

## UI / UX
Admin section can keep current look and fell
Public endpoints should be what we usually expect, we'll improve it in future iterations

## Roles & permissions
Create an admin section where only super admin and product admins can add, edit and delete categories.
Regular users can see categories sort page (public)


