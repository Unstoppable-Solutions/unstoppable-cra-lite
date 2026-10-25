=== Unstoppable CRA Compliance Checker ===
Contributors: paramedic192
Tags: cra, compliance, security, eu, sbom
Requires at least: 5.8
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.3
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Check your WordPress plugins for EU Cyber Resilience Act (CRA) compliance. Scan dependencies, assess your readiness, and prepare for December 2027.

== Description ==

**The EU Cyber Resilience Act is coming. Are you ready?**

By December 2027, all products with digital elements sold in the EU must comply with new cybersecurity requirements. Non-compliance can result in fines up to €15 million or 2.5% of global turnover.

The Unstoppable CRA Compliance Checker helps WordPress plugin developers and site owners understand their compliance gaps and take action before the deadline.

= What This Plugin Does =

**Compliance Dashboard**
See your overall readiness score at a glance. A countdown timer reminds you of the December 2027 deadline, while color-coded status cards show your standing across five CRA compliance pillars.

**Dependency Scanner**
Scan your installed plugins for Composer packages, NPM dependencies, and embedded JavaScript libraries. Understanding your software supply chain is the first step toward SBOM compliance.

**Self-Assessment Questionnaire**
Answer 18 questions about your security practices to identify gaps in vulnerability handling, incident reporting, CE marking readiness, and documentation.

**Security.txt Generator**
Generate a standards-compliant security.txt file (RFC 9116) that provides security researchers with a way to contact you. This satisfies a real CRA requirement and is free to use.

**Educational Content**
Learn about CRA requirements, deadlines, fines, and what you need to do to comply. Plain-language explanations help you understand complex regulatory requirements.

= CRA Compliance Pillars =

The plugin assesses your readiness across five areas:

1. **Software Bill of Materials (SBOM)** - Documenting all software components
2. **Vulnerability Handling** - Security contact, disclosure policy, tracking
3. **Incident Reporting** - Procedures for reporting to ENISA
4. **CE Marking** - Conformity assessment and documentation
5. **Documentation & Security** - Secure design and update policies

= Pro Version =

Need to generate actual compliance deliverables? The Pro version includes:

* SBOM export in CycloneDX and SPDX formats
* Vulnerability tracking workflow
* ENISA-compliant incident report templates
* CE marking documentation generator
* EU Declaration of Conformity templates
* Multi-site / agency features

[Learn more about Pro](https://unstoppablesolutions.app/PluginDetail?slug=unstoppable-cra-compliance)

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to CRA Compliance in the admin menu
4. Run a dependency scan and complete the self-assessment

== Frequently Asked Questions ==

= What is the EU Cyber Resilience Act? =

The CRA is EU legislation establishing cybersecurity requirements for products with digital elements. It requires manufacturers to implement security measures throughout the product lifecycle, handle vulnerabilities properly, and report incidents to authorities.

= Does the CRA apply to WordPress plugins? =

If you sell plugins or themes to EU customers, you may be considered a manufacturer under the CRA. The regulation covers all products with digital elements placed on the EU market.

= What's the deadline? =

Full compliance is required by December 11, 2027. Some requirements (vulnerability handling, incident reporting) apply earlier, from June 11, 2026.

= Is free/open-source software exempt? =

Free and open-source software developed on a non-commercial basis may be exempt, but the boundaries are complex. If you monetize your software in any way, you likely need to comply.

= What happens if I don't comply? =

Fines can reach €15 million or 2.5% of global turnover. Additionally, non-compliant products can be removed from the EU market.

= Does this plugin make me compliant? =

This free plugin helps you understand your compliance gaps. To generate the actual deliverables required by the CRA (SBOMs, documentation, reports), you'll need the Pro version or equivalent tools.

== Screenshots ==

1. Compliance Dashboard with readiness score
2. Dependency Scanner results
3. Self-Assessment questionnaire
4. Security.txt generator
5. Educational content hub

== Changelog ==

= 1.0.3 =
* WordPress.org submission compliance fixes
* Removed load_plugin_textdomain (WordPress handles this automatically)
* Fixed inline styles to use wp_add_inline_style
* Updated plugin header URIs
* Fixed license format to GPL-2.0-or-later
* Reduced tags to maximum of 5
* Fixed readiness score caps

= 1.0.0 =
* Initial release
* Compliance dashboard with readiness score
* Dependency scanner for all installed plugins
* Self-assessment questionnaire (18 questions)
* Security.txt generator (RFC 9116)
* Educational content hub
* Email subscription for regulatory updates

== Upgrade Notice ==

= 1.0.0 =
Initial release of the CRA Compliance Checker.
