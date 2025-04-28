import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/core/theme/theme.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/features/auth/data/auth_api.dart';

class LoginPage extends StatefulWidget {
    const LoginPage({super.key});

    @override
    State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
    final TextEditingController _emailController = TextEditingController();
    final TextEditingController _passwordController = TextEditingController();
    bool _isPasswordVisible = false;
    bool _isLoading = false;

    @override
    void dispose() {
        _emailController.dispose();
        _passwordController.dispose();
        super.dispose();
    }

    Future<void> _handleLogin() async {
        if (_isLoading) return;

        setState(() {
            _isLoading = true;
        });

        try {
            await AuthAPI.login(
                email: _emailController.text.trim(),
                password: _passwordController.text.trim(),
            );

            ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('Login successful!')),
            );

            // Navigator.pushReplacement(context, MaterialPageRoute(builder: (_) => HomePage()));

        } catch (e) {
            showDialog(
                context: context,
                builder: (context) => AlertDialog(
                    title: const Text('Error'),
                    content: Text(e.toString().replaceAll('Exception: ', '')),
                    actions: [
                        TextButton(
                            onPressed: () => Navigator.of(context).pop(),
                            child: const Text('OK'),
                        ),
                    ],
                ),
            );
        } finally {
            setState(() {
                _isLoading = false;
            });
        }
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
                            icon: const Icon(
                                Icons.chevron_left,
                                size: 24,
                                color: AppColors.placeholder,
                            ),
                        ),
                    ),

                    const SizedBox(height: 16),

                    Text(
                        'Login',
                        style: Theme.of(context).textTheme.headlineLarge?.copyWith(
                            color: AppColors.secondary,
                        ),
                    ),

                    const SizedBox(height: 16),

                    Text(
                        'Login to your account',
                        style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                            color: AppColors.label,
                        ),
                    ),

                    const SizedBox(height: 16),

                    Align(
                        alignment: Alignment.topLeft,
                        child: Text(
                            'Email',
                            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                color: AppColors.label,
                            ),
                        ),
                    ),

                    const SizedBox(height: 4),

                    TextField(
                        controller: _emailController,
                        decoration: InputDecoration(
                            hintText: 'Enter your email',
                            prefixIcon: const Icon(Icons.email, color: AppColors.placeholder),
                        ),
                    ),

                    const SizedBox(height: 16),

                    Align(
                        alignment: Alignment.topLeft,
                        child: Text(
                            'Password',
                            style: Theme.of(context).textTheme.bodyMedium?.copyWith(
                                color: AppColors.label,
                            ),
                        ),
                    ),

                    const SizedBox(height: 4),

                    TextField(
                        controller: _passwordController,
                        obscureText: !_isPasswordVisible,
                        decoration: InputDecoration(
                            hintText: 'Enter your password',
                            prefixIcon: const Icon(Icons.lock, color: AppColors.placeholder),
                            suffixIcon: Padding(
                                padding: const EdgeInsets.only(right: 16),
                                child: IconButton(
                                    icon: Icon(
                                        _isPasswordVisible ? Icons.visibility : Icons.visibility_off,
                                        color: AppColors.placeholder,
                                    ),
                                    onPressed: () {
                                        setState(() {
                                            _isPasswordVisible = !_isPasswordVisible;
                                        });
                                    },
                                ),
                            ),
                        ),
                    ),

                    const SizedBox(height: 16),

                    CustomButton(
                        text: _isLoading ? 'Loading...' : 'Login',
                        onPressed: () {
                            if (!_isLoading) {
                                _handleLogin();
                            }
                        }
                    ),

                    const SizedBox(height: 16),

                    SvgPicture.asset(
                        'lib/assets/images/login.svg',
                        width: MediaQuery.of(context).size.width * 0.9,
                        height: MediaQuery.of(context).size.height * 0.4,
                        fit: BoxFit.contain,
                    ),
                ],
            ),
        );
    }
}
