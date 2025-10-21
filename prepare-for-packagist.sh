#!/bin/bash

# SimPDF Library - Prepare for Packagist Release
# This script helps prepare your library for Packagist publication

echo "🚀 SimPDF Library - Preparing for Packagist Release"
echo "=================================================="
echo ""

# Check if we're in a git repository
if [ ! -d ".git" ]; then
    echo "❌ Error: Not in a git repository"
    echo "Please run this script from your project root directory"
    exit 1
fi

echo "✅ Git repository detected"
echo ""

# Check if composer.json exists
if [ ! -f "composer.json" ]; then
    echo "❌ Error: composer.json not found"
    exit 1
fi

echo "✅ composer.json found"
echo ""

# Check if we're on main branch
current_branch=$(git branch --show-current)
if [ "$current_branch" != "main" ]; then
    echo "⚠️  Warning: You're on branch '$current_branch', not 'main'"
    echo "   Consider switching to main branch: git checkout main"
    echo ""
fi

# Check for uncommitted changes
if [ -n "$(git status --porcelain)" ]; then
    echo "⚠️  Warning: You have uncommitted changes"
    echo "   Please commit or stash your changes before proceeding"
    echo ""
    echo "Current status:"
    git status --short
    echo ""
    read -p "Do you want to continue anyway? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "Aborted. Please commit your changes and run again."
        exit 1
    fi
fi

echo "📋 Pre-release Checklist:"
echo "========================="
echo ""

# Check composer.json structure
echo "1. Checking composer.json structure..."

# Check if package name is correct
if grep -q '"name": "sim-pdf/sim-pdf-libs"' composer.json; then
    echo "   ✅ Package name is correct"
else
    echo "   ❌ Package name should be 'sim-pdf/sim-pdf-libs'"
fi

# Check if description exists
if grep -q '"description"' composer.json; then
    echo "   ✅ Description is present"
else
    echo "   ❌ Description is missing"
fi

# Check if license is set
if grep -q '"license": "MIT"' composer.json; then
    echo "   ✅ License is set to MIT"
else
    echo "   ❌ License should be set to MIT"
fi

# Check if keywords exist
if grep -q '"keywords"' composer.json; then
    echo "   ✅ Keywords are present"
else
    echo "   ❌ Keywords are missing"
fi

echo ""

# Check if README exists
echo "2. Checking documentation..."
if [ -f "README.md" ]; then
    echo "   ✅ README.md exists"
else
    echo "   ❌ README.md is missing"
fi

if [ -f "CHANGELOG.md" ]; then
    echo "   ✅ CHANGELOG.md exists"
else
    echo "   ❌ CHANGELOG.md is missing"
fi

echo ""

# Check if tests exist
echo "3. Checking tests..."
if [ -d "tests" ] && [ "$(ls -A tests)" ]; then
    echo "   ✅ Tests directory exists and is not empty"
else
    echo "   ⚠️  Tests directory is missing or empty"
fi

echo ""

# Check if src directory exists
echo "4. Checking source code..."
if [ -d "src" ] && [ "$(ls -A src)" ]; then
    echo "   ✅ Source code directory exists and is not empty"
else
    echo "   ❌ Source code directory is missing or empty"
fi

echo ""

# Check if vendor directory exists (for dependencies)
echo "5. Checking dependencies..."
if [ -f "composer.lock" ]; then
    echo "   ✅ Dependencies are locked"
else
    echo "   ⚠️  composer.lock is missing (run 'composer install')"
fi

echo ""

# Check if .gitignore exists
echo "6. Checking .gitignore..."
if [ -f ".gitignore" ]; then
    echo "   ✅ .gitignore exists"
else
    echo "   ⚠️  .gitignore is missing"
fi

echo ""

# Final steps
echo "🎯 Next Steps:"
echo "=============="
echo ""
echo "1. Update your email in composer.json (line 9):"
echo "   'email': 'your-actual-email@example.com'"
echo ""
echo "2. Commit all changes:"
echo "   git add ."
echo "   git commit -m 'Prepare for Packagist release v1.0.0'"
echo ""
echo "3. Create and push version tag:"
echo "   git tag -a v1.0.0 -m 'Release version 1.0.0'"
echo "   git push origin main"
echo "   git push origin v1.0.0"
echo ""
echo "4. Submit to Packagist:"
echo "   - Go to https://packagist.org"
echo "   - Click 'Submit'"
echo "   - Enter: https://github.com/5u00n/sim-pdf-libs"
echo "   - Click 'Check' then 'Submit'"
echo ""
echo "5. Enable auto-update:"
echo "   - Go to your package settings on Packagist"
echo "   - Copy the webhook URL"
echo "   - Add webhook in GitHub repository settings"
echo ""

echo "📚 For detailed instructions, see: PACKAGIST_PUBLISHING_GUIDE.md"
echo ""
echo "🎉 Good luck with your Packagist submission!"
