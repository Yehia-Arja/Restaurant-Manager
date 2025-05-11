import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:flutter_svg/flutter_svg.dart';

class OnboardingScreen extends StatelessWidget {
  const OnboardingScreen({super.key});

  @override
  Widget build(BuildContext context) {
    return BaseScaffold(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Title (SmartDine)
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
          const SizedBox(height: 16),

          // Tagline
          Text(
            'Experience the future of dining simple, fast, smart.',
            style: Theme.of(
              context,
            ).textTheme.bodyMedium?.copyWith(color: AppColors.label),
          ),
          const SizedBox(height: 16),

          // Centered Image
          Center(
            child: SvgPicture.asset(
              'lib/assets/images/restaurant.svg',
              height: 220,
              width: 260,
            ),
          ),
          const SizedBox(height: 16),

          // Google Button
          CustomButton(
            text: 'Continue with Google',
            isOutlined: true,
            iconPath: 'lib/assets/icons/google-logo.png',
            onPressed: () {},
          ),
          const SizedBox(height: 16),

          // Divider with 'or' text
          Row(
            children: [
              const Expanded(
                child: Divider(
                  thickness: 1,
                  color: AppColors.label,
                  endIndent: 8,
                ),
              ),

              Text(
                'or',
                style: Theme.of(
                  context,
                ).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),

              const Expanded(
                child: Divider(thickness: 1, color: AppColors.label, indent: 8),
              ),
            ],
          ),

          const SizedBox(height: 16),

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
        ],
      ),
    );
  }
}
