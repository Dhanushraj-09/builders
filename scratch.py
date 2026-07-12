import os
import re

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    original_content = content
    # Add CSRF token verification for POST
    if "$_SERVER['REQUEST_METHOD'] === 'POST'" in content and 'verify_csrf_token()' not in content:
        content = content.replace("$_SERVER['REQUEST_METHOD'] === 'POST') {", "$_SERVER['REQUEST_METHOD'] === 'POST') {\n    verify_csrf_token();")

    # Add CSRF token to form
    if '<form' in content and 'name="csrf_token"' not in content:
        # handle multiple forms
        content = re.sub(r'(<form[^>]*>)', r'\1\n    <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">', content)

    if content != original_content:
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Updated POST CSRF in {filepath}")

for root, _, files in os.walk('/opt/lampp/htdocs/builders'):
    for file in files:
        if file.endswith('.php'):
            process_file(os.path.join(root, file))

def process_delete_file(filepath):
    if not os.path.exists(filepath): return
    with open(filepath, 'r') as f:
        content = f.read()
    if 'requireAuth();' in content and 'verify_csrf_token' not in content:
        content = content.replace("requireAuth();", "requireAuth();\nverify_csrf_token($_GET['token'] ?? '');")
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Updated DELETE CSRF in {filepath}")
            
delete_files = ['admin/services/delete.php', 'admin/notifications/delete.php', 'admin/contacts/delete.php', 'admin/projects/delete.php']
for f in delete_files:
    process_delete_file(f'/opt/lampp/htdocs/builders/{f}')

# Now we need to append the token to all delete links
def update_delete_links(filepath):
    with open(filepath, 'r') as f:
        content = f.read()
    
    # Example: href="<?= SITE_URL ?>/admin/projects/delete.php?id=<?= $p['id'] ?>"
    # We want to add &token=<?= generate_csrf_token() ?>
    # Wait, some delete links might be in admin/dashboard.php or admin/projects/index.php
    original_content = content
    if 'delete.php?id=' in content and '&token=' not in content:
        content = re.sub(r'(delete\.php\?id=[^"]*)', r'\1&token=<?= generate_csrf_token() ?>', content)
        content = re.sub(r"(delete\.php\?id=[^']*)", r"\1&token=<?= generate_csrf_token() ?>", content) # handle single quotes if any
        if content != original_content:
            with open(filepath, 'w') as f:
                f.write(content)
            print(f"Updated DELETE links in {filepath}")

for root, _, files in os.walk('/opt/lampp/htdocs/builders/admin'):
    for file in files:
        if file.endswith('.php'):
            update_delete_links(os.path.join(root, file))

