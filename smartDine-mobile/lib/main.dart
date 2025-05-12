import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/services/dio_service.dart';
import 'package:mobile/core/theme/theme.dart';

// Cubits
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';

// Auth
import 'package:mobile/features/auth/data/datasources/auth_remote.dart';
import 'package:mobile/features/auth/data/repositories/auth_repository_impl.dart';
import 'package:mobile/features/auth/domain/usecases/login_usecase.dart';
import 'package:mobile/features/auth/domain/usecases/signup_usecase.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:mobile/features/auth/presentation/screens/onboarding_screen.dart';
import 'package:mobile/features/auth/presentation/screens/login_screen.dart';
import 'package:mobile/features/auth/presentation/screens/signup_screen.dart';

// Restaurant Selection
import 'package:mobile/features/restaurant_selection/data/datasources/restaurant_selection_remote.dart';
import 'package:mobile/features/restaurant_selection/data/datasources/favorite_remote.dart';
import 'package:mobile/features/restaurant_selection/data/repositories/restaurant_selection_repository_impl.dart';
import 'package:mobile/features/restaurant_selection/data/repositories/favorite_repository_impl.dart';
import 'package:mobile/features/restaurant_selection/domain/usecases/get_restaurants_usecase.dart';
import 'package:mobile/features/restaurant_selection/domain/usecases/toggle_favorite_usecase.dart';
import 'package:mobile/features/restaurant_selection/presentation/bloc/restaurant_selection_bloc.dart';
import 'package:mobile/features/restaurant_selection/presentation/screens/restaurant_selection_screen.dart';

// Home
import 'package:mobile/features/home/data/datasources/home_remote.dart';
import 'package:mobile/features/home/data/repositories/home_repository_impl.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/home/presentation/screens/home_page.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  final dio = DioService.dio;

  // Auth setup
  final authRemote = AuthRemote(dio);
  final authRepo = AuthRepositoryImpl(authRemote);
  final loginUseCase = LoginUseCase(authRepo);
  final signupUseCase = SignupUseCase(authRepo);

  // RestaurantSelection setup
  final restaurantRemote = RestaurantSelectionRemote(dio);
  final restaurantRepo = RestaurantSelectionRepositoryImpl(restaurantRemote);
  final getRestaurantsUseCase = GetRestaurantsUseCase(restaurantRepo);

  // Favorite setup
  final favoriteRemote = FavoriteRemote(dio);
  final favoriteRepo = FavoriteRepositoryImpl(favoriteRemote);
  final toggleFavoriteUseCase = ToggleFavoriteUseCase(favoriteRepo);

  // Home setup
  final homeRemote = HomeRemote(dio);
  final homeRepo = HomeRepositoryImpl(homeRemote);
  final getHomeDataUseCase = GetHomeDataUseCase(homeRepo);

  runApp(
    MultiRepositoryProvider(
      providers: [
        RepositoryProvider.value(value: loginUseCase),
        RepositoryProvider.value(value: signupUseCase),
        RepositoryProvider.value(value: getRestaurantsUseCase),
        RepositoryProvider.value(value: toggleFavoriteUseCase),
        RepositoryProvider.value(value: getHomeDataUseCase),
      ],
      child: MultiBlocProvider(
        providers: [
          BlocProvider(create: (_) => SelectedRestaurantCubit()),
          BlocProvider(create: (_) => SelectedBranchCubit()),
          BlocProvider(create: (_) => AuthBloc(loginUseCase, signupUseCase)),
          BlocProvider(
            create: (_) => RestaurantSelectionBloc(getRestaurantsUseCase, toggleFavoriteUseCase),
          ),
          // HomeBloc is provided inside HomePage, so no need to register it here
        ],
        child: const MyApp(),
      ),
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
        '/restaurant_selection': (_) => const RestaurantSelectionScreen(),
        '/home': (_) => const HomePage(),
      },
    );
  }
}
