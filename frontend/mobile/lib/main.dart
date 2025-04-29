import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/services/dio_service.dart';
import 'package:mobile/core/theme/theme.dart';
import 'package:mobile/features/auth/presentation/screens/signup_screen.dart';
import 'package:mobile/features/auth/data/datasources/auth_remote.dart';
import 'package:mobile/features/auth/data/repositories/auth_repository_impl.dart';
import 'package:mobile/features/auth/domain/usecases/login_usecase.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:mobile/features/auth/presentation/screens/onboarding_screen.dart';
import 'package:mobile/features/auth/presentation/screens/login_screen.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();

  // Setup dependencies
  final authRemote = AuthRemote(DioService.dio);
  final authRepo = AuthRepositoryImpl(authRemote);
  final loginUseCase = LoginUseCase(authRepo);

  runApp(
    MultiBlocProvider(
      providers: [
        BlocProvider<AuthBloc>(create: (_) => AuthBloc(loginUseCase)),
      ],
      child: const MyApp(),
    ),
  );
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      theme: AppTheme.lightTheme,
      debugShowCheckedModeBanner: false,
      initialRoute: '/',
      routes: {
        '/': (_) => const OnboardingScreen(),
        '/login': (_) => const LoginScreen(),
        '/signup': (_) => const SignupScreen(),
        '/home': (_) {
          return Scaffold(body: Center(child: Text('Home')));
        },
      },
    );
  }
}
