// lib/main.dart
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

// Main
import 'package:mobile/features/main/presentation/screens/main_screen.dart';

// Home
import 'package:mobile/features/home/data/datasources/home_remote.dart';
import 'package:mobile/features/home/data/repositories/home_repository_impl.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';

// Products (Detail)
import 'package:mobile/features/products/data/datasources/product_remote.dart';
import 'package:mobile/features/products/data/repositories/product_repository_impl.dart';
import 'package:mobile/features/products/domain/usecases/get_product_detail_usecase.dart';
import 'package:mobile/features/products/presentation/widgets/product_detail_page.dart';

// Tables & Orders
import 'package:mobile/features/tables/data/datasource/tables_remote.dart';
import 'package:mobile/features/tables/data/repositories/table_repository_impl.dart';
import 'package:mobile/features/tables/domain/usecases/get_tables_usecase.dart';
import 'package:mobile/features/orders/data/datasource/orders_remote.dart';
import 'package:mobile/features/orders/data/repositories/order_repository_impl.dart';
import 'package:mobile/features/orders/domain/usecases/place_order_usecase.dart';

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
  final getRestaurantsUC = GetRestaurantsUseCase(restaurantRepo);

  // Favorite setup
  final favoriteRemote = FavoriteRemote(dio);
  final favoriteRepo = FavoriteRepositoryImpl(favoriteRemote);
  final toggleFavoriteUC = ToggleFavoriteUseCase(favoriteRepo);

  // Home setup
  final homeRemote = HomeRemote(dio);
  final homeRepo = HomeRepositoryImpl(homeRemote);
  final getHomeDataUC = GetHomeDataUseCase(homeRepo);

  // Products setup
  final productRemote = ProductRemote(dio);
  final productRepo = ProductRepositoryImpl(productRemote);
  final getProductDetailUC = GetProductDetailUseCase(productRepo);

  // Tables setup
  final tablesRemote = TablesRemote(dio);
  final tableRepo = TableRepositoryImpl(tablesRemote);
  final getTablesUC = GetTablesUseCase(tableRepo);

  // Orders setup
  final ordersRemote = OrdersRemote(dio);
  final orderRepo = OrderRepositoryImpl(ordersRemote);
  final placeOrderUC = PlaceOrderUseCase(orderRepo);

  runApp(
    MultiRepositoryProvider(
      providers: [
        // Auth
        RepositoryProvider.value(value: loginUseCase),
        RepositoryProvider.value(value: signupUseCase),
        // RestaurantSelection & Favorites
        RepositoryProvider.value(value: getRestaurantsUC),
        RepositoryProvider.value(value: toggleFavoriteUC),
        // Home
        RepositoryProvider.value(value: getHomeDataUC),
        // Products
        RepositoryProvider.value(value: getProductDetailUC),
        // Tables & Orders
        RepositoryProvider.value(value: getTablesUC),
        RepositoryProvider.value(value: placeOrderUC),
      ],
      child: MultiBlocProvider(
        providers: [
          BlocProvider(create: (_) => SelectedRestaurantCubit()),
          BlocProvider(create: (_) => SelectedBranchCubit()),
          BlocProvider(create: (_) => AuthBloc(loginUseCase, signupUseCase)),
          BlocProvider(create: (_) => RestaurantSelectionBloc(getRestaurantsUC, toggleFavoriteUC)),
          // HomeBloc is provided inside HomePage
          // ProductDetailBloc is provided inside ProductDetailPage
          // OrderBloc is provided inside ProductDetailPage
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
        '/home': (_) => const MainScreen(),
        '/product_detail': (ctx) {
          final args = ModalRoute.of(ctx)!.settings.arguments as int;
          return ProductDetailPage(productId: args);
        },
      },
    );
  }
}
