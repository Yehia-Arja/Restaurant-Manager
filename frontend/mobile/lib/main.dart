import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile/features/auth/presentation/pages/login_page.dart';

void main() {
    WidgetsFlutterBinding.ensureInitialized();
    runApp(
        GetMaterialApp(
            debugShowCheckedModeBanner: false,
            initialRoute: '/login',
            getPages: [
                GetPage(name: '/login', page: () => const LoginPage()),
            ],
        ),
    );
}
