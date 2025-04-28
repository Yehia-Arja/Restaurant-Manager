import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_svg/flutter_svg.dart';

import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/features/auth/controllers/login_controller.dart';

class LoginPage extends StatefulWidget {
    const LoginPage({super.key});
    @override
    State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
    final TextEditingController _emailController    = TextEditingController();
    final TextEditingController _passwordController = TextEditingController();
    late final LoginController _auth;

    @override
    void initState() {
        super.initState();
        _auth = Get.put(LoginController());
    }

    @override
    void dispose() {
        _emailController.dispose();
        _passwordController.dispose();
        super.dispose();
    }

    @override
    Widget build(BuildContext context) {
        return BaseScaffold(
            child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                    Align(
                        alignment: Alignment.topLeft,
                        child: IconButton(
                            onPressed: () => Navigator.pop(context),
                            icon: const Icon(Icons.chevron_left,
                                size: 24, color: AppColors.placeholder),
                        ),
                    ),
                    const SizedBox(height: 16),
                    Text('Login',
                        style: Theme.of(context)
                            .textTheme
                            .headlineLarge
                            ?.copyWith(color: AppColors.secondary)),
                    const SizedBox(height: 16),
                    Text('Login to your account',
                        style: Theme.of(context)
                            .textTheme
                            .bodyMedium
                            ?.copyWith(color: AppColors.label)),
                    const SizedBox(height: 16),
                    Align(
                        alignment: Alignment.topLeft,
                        child: Text('Email',
                            style: Theme.of(context)
                                .textTheme
                                .bodyMedium
                                ?.copyWith(color: AppColors.label)),
                    ),
                    const SizedBox(height: 4),
                    TextField(
                        controller: _emailController,
                        decoration: InputDecoration(
                            hintText: 'Enter your email',
                            prefixIcon:
                                const Icon(Icons.email, color: AppColors.placeholder),
                        ),
                    ),
                    const SizedBox(height: 16),
                    Align(
                        alignment: Alignment.topLeft,
                        child: Text('Password',
                            style: Theme.of(context)
                                .textTheme
                                .bodyMedium
                                ?.copyWith(color: AppColors.label)),
                    ),
                    const SizedBox(height: 4),
                    Obx(() => TextField(
                        controller: _passwordController,
                        obscureText: !_auth.isPasswordVisible.value,
                        decoration: InputDecoration(
                            hintText: 'Enter your password',
                            prefixIcon:
                                const Icon(Icons.lock, color: AppColors.placeholder),
                            suffixIcon: Padding(
                                padding: const EdgeInsets.only(right: 16),
                                child: IconButton(
                                    icon: Icon(
                                        _auth.isPasswordVisible.value
                                            ? Icons.visibility
                                            : Icons.visibility_off,
                                        color: AppColors.placeholder),
                                    onPressed: _auth.togglePasswordVisibility,
                                ),
                            ),
                        ),
                    )),
                    const SizedBox(height: 16),
                    Obx(() => CustomButton(
                        text:
                            _auth.isLoading.value ? 'Loading...' : 'Login',
                        onPressed: () => _auth.handleSubmit(
                            _emailController.text.trim(),
                            _passwordController.text.trim(),
                        ),
                    )),
                    const SizedBox(height: 16),
                    SvgPicture.asset('lib/assets/images/login.svg',
                        width: MediaQuery.of(context).size.width * 0.9, // 90% of screen width
                        height: MediaQuery.of(context).size.height * 0.4, // 40% of screen height
                        fit: BoxFit.contain),
                ],
            ),
        );
    }
}
