import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/services/dio_service.dart';
import 'package:mobile/core/theme/theme.dart';

import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';

import 'package:mobile/features/auth/data/datasources/auth_remote.dart';
import 'package:mobile/features/auth/data/repositories/auth_repository_impl.dart';
import 'package:mobile/features/auth/domain/usecases/login_usecase.dart';
import 'package:mobile/features/auth/domain/usecases/signup_usecase.dart';
import 'package:mobile/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:mobile/features/auth/presentation/screens/onboarding_screen.dart';
import 'package:mobile/features/auth/presentation/screens/login_screen.dart';
import 'package:mobile/features/auth/presentation/screens/signup_screen.dart';

import 'package:mobile/features/restaurant_selection/data/datasources/restaurant_selection_remote.dart';
import 'package:mobile/features/favorite/data/datasources/favorite_remote.dart';
import 'package:mobile/features/restaurant_selection/data/repositories/restaurant_selection_repository_impl.dart';
import 'package:mobile/features/favorite/data/repositories/favorite_repository_impl.dart';
import 'package:mobile/features/restaurant_selection/domain/usecases/get_restaurants_usecase.dart';
import 'package:mobile/features/favorite/domain/usecases/toggle_favorite_usecase.dart';
import 'package:mobile/features/restaurant_selection/presentation/bloc/restaurant_selection_bloc.dart';
import 'package:mobile/features/restaurant_selection/presentation/screens/restaurant_selection_screen.dart';

import 'package:mobile/features/main/presentation/screens/main_screen.dart';

import 'package:mobile/features/home/data/datasources/home_remote.dart';
import 'package:mobile/features/home/data/repositories/home_repository_impl.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';

import 'package:mobile/features/products/data/datasources/product_remote.dart';
import 'package:mobile/features/products/data/repositories/product_repository_impl.dart';
import 'package:mobile/features/products/domain/usecases/get_product_detail_usecase.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';
import 'package:mobile/features/products/presentation/bloc/product_bloc.dart';
import 'package:mobile/features/products/presentation/widgets/product_detail_page.dart';

import 'package:mobile/features/categories/data/datasources/category_remote.dart';
import 'package:mobile/features/categories/data/repositories/category_repository_impl.dart';
import 'package:mobile/features/categories/domain/usecases/list_categories_usecase.dart';
import 'package:mobile/features/search/presentation/bloc/search_bloc.dart';

import 'package:mobile/features/tables/data/datasource/tables_remote.dart';
import 'package:mobile/features/tables/data/repositories/table_repository_impl.dart';
import 'package:mobile/features/tables/domain/usecases/get_tables_usecase.dart';

import 'package:mobile/features/orders/data/datasource/orders_remote.dart';
import 'package:mobile/features/orders/data/repositories/order_repository_impl.dart';
import 'package:mobile/features/orders/domain/usecases/place_order_usecase.dart';

import 'package:mobile/features/assistant/data/repositories/message_repository_impl.dart';
import 'package:mobile/features/assistant/data/datasources/chat_remote.dart';
import 'package:mobile/features/assistant/data/datasources/message_remote.dart';
import 'package:mobile/features/assistant/domain/usecases/send_message_usecase.dart';
import 'package:mobile/features/assistant/domain/usecases/get_chat_history_usecase.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();

  final dio = DioService.dio;

  final authRemote = AuthRemote(dio);
  final authRepo = AuthRepositoryImpl(authRemote);
  final loginUseCase = LoginUseCase(authRepo);
  final signupUseCase = SignupUseCase(authRepo);

  final restaurantRemote = RestaurantSelectionRemote(dio);
  final restaurantRepo = RestaurantSelectionRepositoryImpl(restaurantRemote);
  final getRestaurantsUC = GetRestaurantsUseCase(restaurantRepo);

  final favoriteRemote = FavoriteRemote(dio);
  final favoriteRepo = FavoriteRepositoryImpl(favoriteRemote);
  final toggleFavoriteUC = ToggleFavoriteUseCase(favoriteRepo);

  final homeRemote = HomeRemote(dio);
  final homeRepo = HomeRepositoryImpl(homeRemote);
  final getHomeDataUC = GetHomeDataUseCase(homeRepo);

  final productRemote = ProductRemote(dio);
  final productRepo = ProductRepositoryImpl(productRemote);
  final getProductDetailUC = GetProductDetailUseCase(productRepo);
  final listProductsUC = ListProductsUseCase(productRepo);

  final categoryRemote = CategoryRemote(dio);
  final categoryRepo = CategoryRepositoryImpl(categoryRemote);
  final listCategoriesUC = ListCategoriesUseCase(categoryRepo);

  final tablesRemote = TablesRemote(dio);
  final tableRepo = TableRepositoryImpl(tablesRemote);
  final getTablesUC = GetTablesUseCase(tableRepo);

  final ordersRemote = OrdersRemote(dio);
  final orderRepo = OrderRepositoryImpl(ordersRemote);
  final placeOrderUC = PlaceOrderUseCase(orderRepo);

  final chatRemote = ChatRemote(dio);
  final messageRemote = MessageRemote(dio);
  final messageRepo = MessageRepositoryImpl(chatRemote: chatRemote, messageRemote: messageRemote);
  final sendMessageUC = SendMessage(messageRepo);
  final getChatHistoryUC = GetChatHistory(messageRepo);

  runApp(
    MultiRepositoryProvider(
      providers: [
        RepositoryProvider.value(value: loginUseCase),
        RepositoryProvider.value(value: signupUseCase),
        RepositoryProvider.value(value: getRestaurantsUC),
        RepositoryProvider.value(value: toggleFavoriteUC),
        RepositoryProvider.value(value: getHomeDataUC),
        RepositoryProvider.value(value: getProductDetailUC),
        RepositoryProvider.value(value: listProductsUC),
        RepositoryProvider.value(value: listCategoriesUC),
        RepositoryProvider.value(value: getTablesUC),
        RepositoryProvider.value(value: placeOrderUC),
        RepositoryProvider.value(value: sendMessageUC),
        RepositoryProvider.value(value: getChatHistoryUC),
      ],
      child: MultiBlocProvider(
        providers: [
          BlocProvider(create: (_) => SelectedRestaurantCubit()),
          BlocProvider(create: (_) => SelectedBranchCubit()),
          BlocProvider(create: (_) => AuthBloc(loginUseCase, signupUseCase)),
          BlocProvider(create: (_) => RestaurantSelectionBloc(getRestaurantsUC, toggleFavoriteUC)),
          BlocProvider(create: (_) => HomeBloc(getHomeDataUC, toggleFavoriteUC)), // ✅ fixed here
          BlocProvider(create: (_) => SearchBloc(listCategoriesUC, listProductsUC)),
          BlocProvider(create: (_) => ProductBloc(listProductsUC, toggleFavoriteUC)),
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
