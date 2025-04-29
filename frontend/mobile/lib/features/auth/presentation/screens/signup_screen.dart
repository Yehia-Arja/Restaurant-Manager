import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_event.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_state.dart';

class SignupScreen extends StatefulWidget {
  const SignupScreen({super.key});

  @override
  State<SignupScreen> createState() => _SignupScreenState();
}

class _SignupScreenState extends State<SignupScreen> {
  final TextEditingController _nameController = TextEditingController();
  final TextEditingController _lastNameController = TextEditingController();
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final TextEditingController _confirmPasswordController = TextEditingController();
  bool _isPasswordVisible = false;
  bool _isConfirmPasswordVisible = false;

  @override
  void dispose() {
    _nameController.dispose();
    _lastNameController.dispose();
    _emailController.dispose();
    _passwordController.dispose();
    _confirmPasswordController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<AuthBloc, AuthState>(
      listener: (context, state) {
        if (state is AuthAuthenticated) {
          Navigator.pushReplacementNamed(context, '/home');
        } else if (state is AuthError) {
          showDialog(
            context: context,
            builder:
                (_) => AlertDialog(
                  title: const Text('Error'),
                  content: Text(state.message),
                  actions: [
                    TextButton(onPressed: () => Navigator.pop(context), child: const Text('OK')),
                  ],
                ),
          );
        }
      },
      child: BaseScaffold(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            Align(
              alignment: Alignment.topLeft,
              child: IconButton(
                onPressed: () => Navigator.pop(context),
                icon: const Icon(Icons.chevron_left, size: 24, color: AppColors.placeholder),
              ),
            ),
            const SizedBox(height: 16),
            Text(
              'Sign Up',
              style: Theme.of(
                context,
              ).textTheme.headlineLarge?.copyWith(color: AppColors.secondary),
            ),
            const SizedBox(height: 16),
            Text(
              "Create your account, it's free!",
              style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
            ),
            const SizedBox(height: 16),
            Row(
              children: [
                SizedBox(
                  width: 167,
                  child: TextField(
                    controller: _nameController,
                    decoration: const InputDecoration(
                      hintText: 'First Name',
                      prefixIcon: Icon(Icons.person, color: AppColors.placeholder),
                    ),
                  ),
                ),
                const SizedBox(width: 16),
                SizedBox(
                  width: 167,
                  child: TextField(
                    controller: _lastNameController,
                    decoration: const InputDecoration(
                      hintText: 'Last Name',
                      prefixIcon: Icon(Icons.person, color: AppColors.placeholder),
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 16),
            Align(
              alignment: Alignment.topLeft,
              child: Text(
                'Email',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),
            ),
            const SizedBox(height: 4),
            TextField(
              controller: _emailController,
              decoration: const InputDecoration(
                hintText: 'Enter your email',
                prefixIcon: Icon(Icons.email, color: AppColors.placeholder),
              ),
            ),
            const SizedBox(height: 16),
            Align(
              alignment: Alignment.topLeft,
              child: Text(
                'Password',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),
            ),
            const SizedBox(height: 4),
            TextField(
              controller: _passwordController,
              obscureText: !_isPasswordVisible,
              decoration: InputDecoration(
                hintText: 'Enter your password',
                prefixIcon: const Icon(Icons.lock, color: AppColors.placeholder),
                suffixIcon: IconButton(
                  icon: Icon(
                    _isPasswordVisible ? Icons.visibility : Icons.visibility_off,
                    color: AppColors.placeholder,
                  ),
                  onPressed: () => setState(() => _isPasswordVisible = !_isPasswordVisible),
                ),
              ),
            ),
            const SizedBox(height: 16),
            Align(
              alignment: Alignment.topLeft,
              child: Text(
                'Confirm Password',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),
            ),
            const SizedBox(height: 4),
            TextField(
              controller: _confirmPasswordController,
              obscureText: !_isConfirmPasswordVisible,
              decoration: InputDecoration(
                hintText: 'Confirm your password',
                prefixIcon: const Icon(Icons.lock, color: AppColors.placeholder),
                suffixIcon: IconButton(
                  icon: Icon(
                    _isConfirmPasswordVisible ? Icons.visibility : Icons.visibility_off,
                    color: AppColors.placeholder,
                  ),
                  onPressed:
                      () => setState(() => _isConfirmPasswordVisible = !_isConfirmPasswordVisible),
                ),
              ),
            ),
            const SizedBox(height: 16),
            BlocBuilder<AuthBloc, AuthState>(
              builder: (context, state) {
                final isLoading = state is AuthLoading;
                return CustomButton(
                  child:
                      isLoading
                          ? const SizedBox(
                            width: 24,
                            height: 24,
                            child: CircularProgressIndicator(
                              color: AppColors.primary,
                              strokeWidth: 2,
                            ),
                          )
                          : const Text('Sign Up'),
                  onPressed: () {
                    final name = _nameController.text.trim();
                    final lastName = _lastNameController.text.trim();
                    final email = _emailController.text.trim();
                    final password = _passwordController.text.trim();
                    final confirmPassword = _confirmPasswordController.text.trim();
                    context.read<AuthBloc>().add(
                      SignupRequested(name, lastName, email, password, confirmPassword),
                    );
                  },
                );
              },
            ),
          ],
        ),
      ),
    );
  }
}
