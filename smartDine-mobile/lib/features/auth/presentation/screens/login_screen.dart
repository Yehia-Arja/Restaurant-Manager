import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/shared/widgets/custom_button.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_event.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_state.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  final FocusNode _emailFocus = FocusNode();
  final FocusNode _passwordFocus = FocusNode();
  final ScrollController _scrollController = ScrollController();

  bool _isPasswordVisible = false;

  @override
  void dispose() {
    _emailController.dispose();
    _passwordController.dispose();
    _emailFocus.dispose();
    _passwordFocus.dispose();
    _scrollController.dispose();
    super.dispose();
  }

  void _scrollTo(FocusNode focusNode) {
    Future.delayed(const Duration(milliseconds: 300), () {
      if (_scrollController.hasClients) {
        _scrollController.animateTo(
          focusNode.offset.dy,
          duration: const Duration(milliseconds: 300),
          curve: Curves.easeInOut,
        );
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<AuthBloc, AuthState>(
      listener: (context, state) {
        if (state is AuthAuthenticated) {
          Navigator.pushReplacementNamed(context, '/restaurant_selection');
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
        child: SingleChildScrollView(
          controller: _scrollController,
          padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              // Back button with padding
              Padding(
                padding: const EdgeInsets.only(left: 4),
                child: Align(
                  alignment: Alignment.topLeft,
                  child: IconButton(
                    onPressed: () => Navigator.pop(context),
                    icon: const Icon(Icons.chevron_left, size: 24, color: AppColors.placeholder),
                  ),
                ),
              ),
              const SizedBox(height: 8),

              // Title
              Text(
                'Login',
                style: Theme.of(
                  context,
                ).textTheme.headlineLarge?.copyWith(color: AppColors.secondary),
              ),
              const SizedBox(height: 8),

              // Subtitle
              Text(
                'Login to your account',
                style: Theme.of(context).textTheme.bodyMedium?.copyWith(color: AppColors.label),
              ),
              const SizedBox(height: 12),

              // Wider and better-fitted SVG image
              ClipRRect(
                borderRadius: BorderRadius.circular(12),
                child: SvgPicture.asset(
                  'lib/assets/images/login.svg',
                  width: double.infinity,
                  height: MediaQuery.of(context).size.height * 0.24,
                  fit: BoxFit.cover,
                  alignment: Alignment.topCenter,
                ),
              ),
              const SizedBox(height: 20),

              // Email Label
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
                focusNode: _emailFocus,
                onTap: () => _scrollTo(_emailFocus),
                decoration: const InputDecoration(
                  hintText: 'Enter your email',
                  prefixIcon: Icon(Icons.email, color: AppColors.placeholder),
                ),
              ),
              const SizedBox(height: 16),

              // Password Label
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
                focusNode: _passwordFocus,
                onTap: () => _scrollTo(_passwordFocus),
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
                      onPressed: () => setState(() => _isPasswordVisible = !_isPasswordVisible),
                    ),
                  ),
                ),
              ),
              const SizedBox(height: 20),

              // Login Button
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
                            : const Text('Login'),
                    onPressed: () {
                      if (!isLoading) {
                        final email = _emailController.text.trim();
                        final password = _passwordController.text.trim();
                        context.read<AuthBloc>().add(LoginRequested(email, password));
                      }
                    },
                  );
                },
              ),
            ],
          ),
        ),
      ),
    );
  }
}
