import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';

class OnboardingPage extends StatelessWidget {
  const OnboardingPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // The global scaffoldBackgroundColor is applied from AppTheme
      body: SafeArea(
        child: Padding(
          padding: const EdgeInsets.symmetric(horizontal: 20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              // App name with mixed colors using RichText
              RichText(
                text: TextSpan(
                  style: Theme.of(context).textTheme.headlineMedium,
                  children: const [
                    TextSpan(
                      text: 'Smart',
                      style: TextStyle(color: AppColors.secondary),
                    ),
                    TextSpan(
                      text: 'Dine',
                      style: TextStyle(color: AppColors.accent),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 24),

              // The following ElevatedButtons use the style defined in AppTheme.elevatedButtonTheme
              // Wrapped in SizedBox to control width and height
              SizedBox(
                width: double.infinity,
                height: 57,
                child: ElevatedButton(
                  onPressed: () {
                    // Handle "Get Started"
                  },
                  child: const Text('Get Started'),
                ),
              ),
              const SizedBox(height: 12),

              SizedBox(
                width: double.infinity,
                height: 57,
                child: ElevatedButton(
                  onPressed: () {
                    // Handle "Login"
                  },
                  child: const Text('Login'),
                ),
              ),
              const SizedBox(height: 12),

              SizedBox(
                width: double.infinity,
                height: 57,
                child: ElevatedButton(
                  onPressed: () {
                    // Handle "Sign Up"
                  },
                  child: const Text('Sign Up'),
                ),
              ),

              // Add more SizedBox+ElevatedButton widgets here as needed
            ],
          ),
        ),
      ),
    );
  }
}
