import os
import glob

def replace_in_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    replacements = {
        'bg-gray-50': 'bg-gray-50 dark:bg-[#0c0c0f]',
        'bg-white': 'bg-white dark:bg-[#1a1a1d]',
        'text-gray-900': 'text-gray-900 dark:text-gray-100',
        'text-gray-700': 'text-gray-700 dark:text-gray-200',
        'text-gray-600': 'text-gray-600 dark:text-gray-300',
        'text-gray-500': 'text-gray-500 dark:text-gray-400',
        'border-gray-200': 'border-gray-200 dark:border-white/10',
        'border-gray-100': 'border-gray-100 dark:border-white/5',
        'bg-gray-100': 'bg-gray-100 dark:bg-white/5',
        'bg-gray-200': 'bg-gray-200 dark:bg-white/10',
        'hover:bg-gray-200': 'hover:bg-gray-200 dark:hover:bg-white/10',
        'bg-blue-100': 'bg-blue-100 dark:bg-blue-900/30',
        'bg-yellow-100': 'bg-yellow-100 dark:bg-yellow-900/30',
        'bg-green-100': 'bg-green-100 dark:bg-green-900/30',
        'bg-purple-100': 'bg-purple-100 dark:bg-purple-900/30',
        'bg-red-50': 'bg-red-50 dark:bg-red-900/20',
        'border-gray-300': 'border-gray-300 dark:border-white/20',
        'hover:border-blue-300': 'hover:border-blue-300 dark:hover:border-blue-500/50',
        'hover:border-purple-300': 'hover:border-purple-300 dark:hover:border-purple-500/50',
    }

    original_content = content
    for old, new in replacements.items():
        # simple string replacement, carefully avoiding double-replacements if already patched
        # Since I'm doing it once, it should be fine. But to be safe, avoid replacing if 'dark:' is already next to it
        # Actually it's easier to just replace, and if there's any ' dark:bg-[#0c0c0f] dark:bg-[#0c0c0f]', we can clean it later, but this is the first run.
        content = content.replace(old, new)

    if content != original_content:
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Patched {filepath}")

admin_dir = 'resources/views/admin'
files = glob.glob(f"{admin_dir}/**/*.blade.php", recursive=True)

for file in files:
    replace_in_file(file)

print("Done patching admin views.")
