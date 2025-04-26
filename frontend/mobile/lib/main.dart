import 'package:flutter/material.dart';
import 'features/auth/presentation/pages/onboarding_page.dart';
import 'package:mobile/core/theme/theme.dart';


void main() {
    // Flutter’s entry point: kicks off the widget tree.
    runApp(const MyApp());
}

class MyApp extends StatelessWidget {
    const MyApp({Key? key}) : super(key: key);

    @override
    Widget build(BuildContext context) {
        // MaterialApp is the root of every Material-style app.
        return MaterialApp(
            // A title for Android’s task switcher, not shown in UI.
            title: 'MyApp',

            theme: AppTheme.lightTheme, // Use the light theme defined in theme.dart

            // Instead of home:, we’ll use named routes:
            initialRoute: '/',  

            // Map string names to widget builders:
            routes: {
                // when Navigator.pushNamed('/') is called, it shows OnboardingPage
                '/': (_) => const OnboardingPage(),
            },
        );
    }
}