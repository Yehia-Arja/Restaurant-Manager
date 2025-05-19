import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:flutter_svg/flutter_svg.dart';

class OnboardingScreen extends StatelessWidget {
  const OnboardingScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final mediaQuery = MediaQuery.of(context);
    final screenHeight = mediaQuery.size.height;

    return BaseScaffold(
      child: SingleChildScrollView(
        child: Padding(
          padding: EdgeInsets.symmetric(horizontal: 24, vertical: screenHeight * 0.08),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              // SmartDine (centered)
              Center(
                child: RichText(
                  textAlign: TextAlign.center,
                  text: TextSpan(
                    style: Theme.of(context).textTheme.headlineMedium,
                    children: const [
                      TextSpan(text: 'Smart', style: TextStyle(color: AppColors.secondary)),
                      TextSpan(text: 'Dine', style: TextStyle(color: AppColors.accent)),
                    ],
                  ),
                ),
              ),
              const SizedBox(height: 12),

              // Tagline (centered)
              Text(
                'Experience the future of dining simple, fast, smart.',
                textAlign: TextAlign.center,
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),
              const SizedBox(height: 24),

              // Centered Image
              Center(
                child: SvgPicture.asset(
                  'lib/assets/images/restaurant.svg',
                  height: screenHeight * 0.27,
                  width: screenHeight * 0.35,
                ),
              ),
              const SizedBox(height: 32),

              // Login Button
              CustomButton(
                text: 'Login',
                onPressed: () {
                  Navigator.pushNamed(context, '/login');
                },
              ),
              const SizedBox(height: 16),

              // Sign Up Button
              CustomButton(
                text: 'Sign Up',
                isSecondary: true,
                onPressed: () {
                  Navigator.pushNamed(context, '/signup');
                },
              ),
              const SizedBox(height: 16),

              // Divider with 'or'
              Row(
                children: [
                  const Expanded(
                    child: Divider(thickness: 1, color: AppColors.label, endIndent: 8),
                  ),
                  Text(
                    'or',
                    style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
                  ),
                  const Expanded(child: Divider(thickness: 1, color: AppColors.label, indent: 8)),
                ],
              ),
              const SizedBox(height: 16),

              // Google Button (now last)
              CustomButton(
                text: 'Continue with Google',
                isOutlined: true,
                iconPath: 'lib/assets/icons/google-logo.png',
                onPressed: () {},
              ),
            ],
          ),
        ),
      ),
    );
  }
}
