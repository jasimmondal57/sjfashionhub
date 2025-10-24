import 'package:flutter/material.dart';
import '../../config/app_theme.dart';

/// Settings Screen
class SettingsScreen extends StatefulWidget {
  const SettingsScreen({super.key});

  @override
  State<SettingsScreen> createState() => _SettingsScreenState();
}

class _SettingsScreenState extends State<SettingsScreen> {
  bool _pushNotifications = true;
  bool _emailNotifications = false;
  bool _smsNotifications = false;
  bool _darkMode = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppTheme.backgroundLight,
      appBar: AppBar(
        title: const Text('Settings'),
        centerTitle: true,
      ),
      body: ListView(
        children: [
          _buildSection('Notifications'),
          _buildSwitchTile(
            title: 'Push Notifications',
            subtitle: 'Receive push notifications',
            value: _pushNotifications,
            onChanged: (value) {
              setState(() => _pushNotifications = value);
            },
          ),
          _buildSwitchTile(
            title: 'Email Notifications',
            subtitle: 'Receive email updates',
            value: _emailNotifications,
            onChanged: (value) {
              setState(() => _emailNotifications = value);
            },
          ),
          _buildSwitchTile(
            title: 'SMS Notifications',
            subtitle: 'Receive SMS updates',
            value: _smsNotifications,
            onChanged: (value) {
              setState(() => _smsNotifications = value);
            },
          ),
          const Divider(height: 1),
          
          _buildSection('Appearance'),
          _buildSwitchTile(
            title: 'Dark Mode',
            subtitle: 'Enable dark theme',
            value: _darkMode,
            onChanged: (value) {
              setState(() => _darkMode = value);
            },
          ),
          const Divider(height: 1),
          
          _buildSection('Account'),
          _buildTile(
            icon: Icons.person,
            title: 'Edit Profile',
            onTap: () {
              Navigator.pushNamed(context, '/edit-profile');
            },
          ),
          _buildTile(
            icon: Icons.lock,
            title: 'Change Password',
            onTap: () {
              Navigator.pushNamed(context, '/change-password');
            },
          ),
          const Divider(height: 1),
          
          _buildSection('Preferences'),
          _buildTile(
            icon: Icons.language,
            title: 'Language',
            trailing: 'English',
            onTap: () {},
          ),
          _buildTile(
            icon: Icons.currency_rupee,
            title: 'Currency',
            trailing: 'INR',
            onTap: () {},
          ),
          const Divider(height: 1),
          
          _buildSection('Legal'),
          _buildTile(
            icon: Icons.description,
            title: 'Terms & Conditions',
            onTap: () {
              Navigator.pushNamed(context, '/terms');
            },
          ),
          _buildTile(
            icon: Icons.privacy_tip,
            title: 'Privacy Policy',
            onTap: () {
              Navigator.pushNamed(context, '/privacy');
            },
          ),
          const Divider(height: 1),
          
          _buildSection('App'),
          _buildTile(
            icon: Icons.info,
            title: 'About',
            trailing: 'v1.0.0',
            onTap: () {
              Navigator.pushNamed(context, '/about');
            },
          ),
          _buildTile(
            icon: Icons.delete_outline,
            title: 'Clear Cache',
            onTap: _showClearCacheDialog,
          ),
          
          const SizedBox(height: 32),
        ],
      ),
    );
  }

  Widget _buildSection(String title) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(16, 24, 16, 8),
      child: Text(
        title,
        style: const TextStyle(
          fontSize: 14,
          fontWeight: FontWeight.w700,
          color: AppTheme.textSecondary,
        ),
      ),
    );
  }

  Widget _buildTile({
    required IconData icon,
    required String title,
    String? trailing,
    required VoidCallback onTap,
  }) {
    return ListTile(
      leading: Icon(icon),
      title: Text(title),
      trailing: trailing != null
          ? Text(
              trailing,
              style: TextStyle(color: AppTheme.textSecondary),
            )
          : const Icon(Icons.chevron_right),
      onTap: onTap,
    );
  }

  Widget _buildSwitchTile({
    required String title,
    required String subtitle,
    required bool value,
    required ValueChanged<bool> onChanged,
  }) {
    return SwitchListTile(
      title: Text(title),
      subtitle: Text(subtitle),
      value: value,
      onChanged: onChanged,
    );
  }

  void _showClearCacheDialog() {
    showDialog(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Clear Cache'),
        content: const Text('Are you sure you want to clear the cache?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.pop(context),
            child: const Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              Navigator.pop(context);
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(
                  content: Text('Cache cleared successfully'),
                  backgroundColor: Colors.green,
                ),
              );
            },
            child: const Text('Clear'),
          ),
        ],
      ),
    );
  }
}

