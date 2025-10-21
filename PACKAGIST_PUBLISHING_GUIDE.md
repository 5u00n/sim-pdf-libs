# Publishing SimPDF Library to Packagist

## 🚀 Complete Guide to Publish Your Library on Packagist

### Prerequisites

- GitHub repository: [https://github.com/5u00n/sim-pdf-libs](https://github.com/5u00n/sim-pdf-libs)
- Packagist account (free)
- Git installed locally

### Step 1: Create Packagist Account

1. Go to [https://packagist.org](https://packagist.org)
2. Click "Sign up" or "Log in"
3. Sign up using your GitHub account (recommended)
4. Verify your email address

### Step 2: Prepare Your Repository

#### 2.1 Update composer.json (Already Done ✅)

Your `composer.json` is already properly configured with:

- ✅ Correct package name: `sim-pdf/sim-pdf-libs`
- ✅ Description
- ✅ License (MIT)
- ✅ Author information
- ✅ Keywords
- ✅ Homepage and support URLs
- ✅ Proper autoloading
- ✅ Laravel service provider configuration

#### 2.2 Create a Git Tag for Version 1.0.0

```bash
# In your project directory
cd /Users/suren/Documents/GitProjects/sim-pdf-libs

# Add all changes
git add .

# Commit changes
git commit -m "Prepare for Packagist release v1.0.0"

# Create and push version tag
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin main
git push origin v1.0.0
```

### Step 3: Submit to Packagist

#### 3.1 Submit Your Package

1. Go to [https://packagist.org](https://packagist.org)
2. Click "Submit" in the top navigation
3. Enter your repository URL: `https://github.com/5u00n/sim-pdf-libs`
4. Click "Check" to validate the package
5. Review the package details
6. Click "Submit" to publish

#### 3.2 Enable Auto-Update (Recommended)

1. After submission, go to your package page
2. Click "Settings" tab
3. Enable "Auto-update" by adding a GitHub webhook
4. Copy the webhook URL provided
5. Go to your GitHub repository settings
6. Navigate to "Webhooks" → "Add webhook"
7. Paste the Packagist webhook URL
8. Select "Just the push event"
9. Click "Add webhook"

### Step 4: Verify Installation

Once published, test the installation:

```bash
# In a new Laravel project
composer require sim-pdf/sim-pdf-libs

# Or with specific version
composer require sim-pdf/sim-pdf-libs:^1.0
```

### Step 5: Update Documentation

#### 5.1 Update README.md

Update the installation section in your README:

````markdown
## Installation

1. Install the package via Composer:

```bash
composer require sim-pdf/sim-pdf-libs
```
````

2. Publish the configuration file:

```bash
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="config"
```

3. Publish the views (optional):

```bash
php artisan vendor:publish --provider="SimPdf\SimPdfLibs\SimPdfServiceProvider" --tag="views"
```

````

#### 5.2 Create CHANGELOG.md

```markdown
# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2024-10-21

### Added
- Initial release
- Multi-page PDF support
- Custom page breaks
- Table pagination
- Page numbering
- Headers and footers
- Advanced CSS styling
- Watermarks and bookmarks
- Metadata support
- Laravel integration
- Comprehensive documentation
- Unit tests
- Example usage

### Features
- 🚀 Multi-page Support - Handle large documents with automatic pagination
- 📄 Custom Page Breaks - Break pages anywhere you want, even within tables
- 📊 Table Pagination - Smart table breaking with repeated headers
- 🔢 Page Numbering - Automatic page numbering with custom formats
- 📋 Headers & Footers - Customizable headers and footers for each page
- 🎨 Advanced Styling - Full CSS support including Microsoft Word-like formatting
- 💧 Watermarks - Add watermarks to your PDFs
- 🔖 Bookmarks - Create PDF bookmarks for navigation
- 📝 Metadata - Set PDF metadata (title, author, subject, etc.)
- ⚡ Performance - Optimized for large documents and high performance
````

### Step 6: Create GitHub Release

1. Go to your GitHub repository
2. Click "Releases" → "Create a new release"
3. Choose tag: `v1.0.0`
4. Release title: `SimPDF Library v1.0.0`
5. Description: Copy from CHANGELOG.md
6. Click "Publish release"

### Step 7: Promote Your Package

#### 7.1 Update Integration Guides

Update all integration guides to use Packagist installation:

```bash
# Simple installation from Packagist
composer require sim-pdf/sim-pdf-libs
```

#### 7.2 Social Media Promotion

Share your package on:

- Twitter/X
- LinkedIn
- Reddit (r/PHP, r/Laravel)
- Laravel News
- PHP Weekly

#### 7.3 Documentation Sites

Submit to:

- [Laravel Package Directory](https://packagist.org/packages/sim-pdf/sim-pdf-libs)
- [Awesome Laravel](https://github.com/chiraggude/awesome-laravel)
- [Laravel Daily](https://laraveldaily.com)

### Step 8: Maintenance

#### 8.1 Version Management

For future releases:

```bash
# Update version in composer.json
# Create new tag
git tag -a v1.1.0 -m "Release version 1.1.0"
git push origin main
git push origin v1.1.0

# Packagist will auto-update if webhook is configured
```

#### 8.2 Monitor Usage

- Check Packagist statistics
- Monitor GitHub stars and forks
- Respond to issues and pull requests
- Update documentation as needed

### Step 9: Troubleshooting

#### Common Issues:

1. **Package not found after submission**

   - Wait 5-10 minutes for Packagist to process
   - Check if the package name is correct
   - Verify the repository URL

2. **Auto-update not working**

   - Check webhook configuration in GitHub
   - Verify Packagist webhook URL
   - Test webhook delivery

3. **Version not updating**
   - Ensure you pushed the tag: `git push origin v1.0.0`
   - Check if auto-update is enabled
   - Manually trigger update in Packagist

### Step 10: Success Checklist

- ✅ Repository is public on GitHub
- ✅ composer.json is properly configured
- ✅ Version tag v1.0.0 is created and pushed
- ✅ Package is submitted to Packagist
- ✅ Auto-update webhook is configured
- ✅ Installation works: `composer require sim-pdf/sim-pdf-libs`
- ✅ README.md is updated
- ✅ CHANGELOG.md is created
- ✅ GitHub release is published
- ✅ Documentation is comprehensive

## 🎉 Congratulations!

Your SimPDF library is now published on Packagist! Users can install it with:

```bash
composer require sim-pdf/sim-pdf-libs
```

**Packagist URL:** [https://packagist.org/packages/sim-pdf/sim-pdf-libs](https://packagist.org/packages/sim-pdf/sim-pdf-libs)

**GitHub Repository:** [https://github.com/5u00n/sim-pdf-libs](https://github.com/5u00n/sim-pdf-libs)
