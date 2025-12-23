# TODO: Implement Category Matching for Staff and Tickets

## Steps to Complete:
1. Modify TicketController create() and edit() methods to filter staffList based on ticket category. - DONE
2. Add custom validation in TicketController store() and update() methods to ensure assigned staff has the matching category. - DONE
3. Update the ticket form views to dynamically filter staff based on selected category (if needed, but focus on backend first). - DONE
4. Test the implementation to ensure staff cannot be assigned to tickets with mismatched categories. - DONE

## Files to Edit:
- app/Http/Controllers/TicketController.php - DONE
- Possibly resources/views/admin/ticket/form.blade.php (for dynamic filtering) - DONE

## Dependent Files:
- None additional.

## Followup Steps:
- Run tests to verify functionality.
- Ensure no existing tickets violate the rule.
