import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:flutter_svg/flutter_svg.dart';

class OnboardingPage extends StatelessWidget {
    const OnboardingPage({super.key});

    @override
    Widget build(BuildContext context) {
        return Scaffold(
            body: SafeArea(
                child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20),
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
                                style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                    color: AppColors.label,
                                ),
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

                            // Buttons
                            CustomButton(
                                text: 'Continue with Google',
                                isOutlined: true,
                                iconPath: 'lib/assets/icons/google-logo.png',
                                onPressed: () {},
                            ),

                            const SizedBox(height: 16),

                            // Divider with "or"
                            Row(
                                children: [
                                    const Expanded(
                                        child: Divider(
                                            color: AppColors.label,
                                            thickness: 1,
                                            endIndent: 8,
                                        ),
                                    ),
                                    Text(
                                        'or',
                                        style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                                            color: AppColors.label,
                                        ),
                                    ),
                                    const Expanded(
                                        child: Divider(
                                            color: AppColors.label,
                                            thickness: 1,
                                            indent: 8,
                                        ),
                                    ),
                                ],
                            ),

                            const SizedBox(height: 16),

                            CustomButton(
                                text: 'Login',
                                onPressed: () {
                                    Navigator.pushNamed(context, '/login');
                                },
                            ),

                            const SizedBox(height: 16),

                            CustomButton(
                                text: 'Sign Up',
                                isSecondary: true,
                                onPressed: () {
                                    Navigator.pushNamed(context, '/signup');
                                },
                            ),
                        ],
                    ),
                ),
            ),
        );
    }
}
