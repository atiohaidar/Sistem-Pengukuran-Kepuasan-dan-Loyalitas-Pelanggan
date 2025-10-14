# Cleanup Instructions

## Purpose
After migrating to Bootstrap 5 via CDN, several internal asset files are no longer needed. This document provides instructions for safely removing them.

## ⚠️ IMPORTANT: Before Deleting

1. **Test the application thoroughly** to ensure all features work correctly
2. **Create a backup** of the `public/assets_backend` and `public/assets_frontend` directories
3. **Check if any custom code** references these files directly
4. Review the BOOTSTRAP_MIGRATION.md file for complete details

## Recommended Cleanup Steps

### Step 1: Create a Backup (REQUIRED)
```bash
# From project root
tar -czf assets_backup_$(date +%Y%m%d).tar.gz public/assets_backend public/assets_frontend
```

### Step 2: Test the Application
1. Login to admin panel
2. Test all navigation links
3. Test survey forms
4. Test data tables (sort, filter, search)
5. Test SPP evaluation
6. Test charts and visualizations
7. Test on mobile devices

### Step 3: Remove Unused Assets

**Option A: Move to Archive (Safer)**
```bash
# Create archive directory
mkdir -p storage/old_assets

# Move unused directories
mv public/assets_backend storage/old_assets/
mv public/css/app.css storage/old_assets/
```

**Option B: Delete Permanently (After Testing)**
```bash
# ⚠️ WARNING: This is permanent!
# Only do this after thorough testing and backup

# Remove AdminLTE and plugin assets
rm -rf public/assets_backend/dist
rm -rf public/assets_backend/plugins

# Or remove the entire backend assets directory
rm -rf public/assets_backend
```

### Step 4: Clean Up Frontend Assets (If Not Used)

First, check if `menu.blade.php` or other files use frontend assets:
```bash
grep -r "assets_frontend" resources/views/
```

If they're not used:
```bash
# Move to archive first
mv public/assets_frontend storage/old_assets/

# After testing, can delete
rm -rf public/assets_frontend
```

### Step 5: Update .gitignore (Optional)

If you want to prevent accidentally adding old assets back:
```bash
echo "storage/old_assets/" >> .gitignore
```

## Files That Can Be Safely Removed

See [BOOTSTRAP_MIGRATION.md](./BOOTSTRAP_MIGRATION.md) for the complete list of removable files.

### Summary of Removable Directories:
- `public/assets_backend/dist/` - AdminLTE distribution files
- `public/assets_backend/plugins/` - AdminLTE plugins (FontAwesome, jQuery UI, etc.)
- `public/css/app.css` - Laravel Mix compiled CSS (if not used elsewhere)

### Files to Keep:
- Any background images still referenced in views
- Custom logos or company-specific images
- Any files referenced in blade templates outside of layout files

## Verification After Cleanup

Run these checks after cleanup:

1. **Check for 404 errors**:
   - Open browser DevTools (F12)
   - Navigate through all pages
   - Look for failed resource requests

2. **Check for broken styles**:
   - All pages should display correctly
   - Tables should be formatted properly
   - Forms should be styled consistently

3. **Check for broken JavaScript**:
   - DataTables should work
   - Modals should open/close
   - Forms should validate
   - Charts should render

## Rollback Plan

If something breaks after cleanup:

**From Archive:**
```bash
# Restore from storage/old_assets
cp -r storage/old_assets/assets_backend public/
cp -r storage/old_assets/assets_frontend public/
```

**From Backup:**
```bash
# Extract from backup
tar -xzf assets_backup_YYYYMMDD.tar.gz
```

## Space Savings

Approximate disk space that will be freed:
- `assets_backend/`: ~15-20 MB
- `assets_frontend/`: ~5-10 MB
- **Total**: ~20-30 MB

## Long-term Maintenance

After successful cleanup:

1. **Document the change** in your project's main README
2. **Update deployment scripts** to not copy old asset directories
3. **Inform team members** about the new CDN-based structure
4. **Monitor CDN availability** in production (consider a CDN fallback if needed)

## CDN Fallback Strategy (Optional)

If you want to ensure availability even if CDN is down, you can implement a fallback:

```html
<!-- Example fallback for Bootstrap CSS -->
<link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      integrity="sha384-..." 
      crossorigin="anonymous"
      onerror="this.onerror=null; this.href='/css/bootstrap.min.css'">
```

However, major CDNs (jsDelivr, cdnjs) have 99.9%+ uptime, so fallbacks are usually unnecessary.

## Support

If you encounter issues after cleanup:

1. Check browser console for errors
2. Review BOOTSTRAP_MIGRATION.md
3. Restore from backup if needed
4. Check that CDN links in layout files are correct and accessible

## Checklist

- [ ] Backup created
- [ ] Application tested thoroughly
- [ ] All features working correctly
- [ ] Old assets moved to archive or deleted
- [ ] Application tested again after cleanup
- [ ] No 404 errors in browser console
- [ ] All pages display correctly
- [ ] Documentation updated
- [ ] Team informed of changes
