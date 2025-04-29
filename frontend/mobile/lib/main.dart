import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile/core/theme/theme.dart';
import 'package:mobile/features/auth/presentation/pages/login_page.dart';
import 'package:mobile/features/auth/presentation/pages/onboarding_page.dart';

void main() {
    WidgetsFlutterBinding.ensureInitialized();
    runApp(
        GetMaterialApp(
            theme: AppTheme.lightTheme,
            debugShowCheckedModeBanner: false,
            initialRoute: '/',
            getPages: [
                GetPage(name: '/', page: () => const OnboardingPage()),
                GetPage(name: '/login', page: () => const LoginPage()),
            ],
        ),
    );
}
