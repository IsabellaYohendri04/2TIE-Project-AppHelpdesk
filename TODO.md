# TODO: Implement Search for Categories

## Steps to Complete
- [ ] Modify CategoryController index method to handle 'search' GET parameter and implement search logic
- [ ] Add search form to category index view above the table
- [ ] Test the search functionality

## Details
- Search logic: If keyword is numeric, filter by exact matches on users_count or tickets_count; otherwise, filter category name with LIKE.
- Files to edit: app/Http/Controllers/CategoryController.php, resources/views/admin/category/index.blade.php
