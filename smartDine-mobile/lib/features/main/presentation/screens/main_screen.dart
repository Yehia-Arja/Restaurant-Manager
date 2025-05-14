import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/screens/home_screen.dart';
import 'package:mobile/features/search/presentation/bloc/search_bloc.dart';
import 'package:mobile/features/search/presentation/bloc/search_event.dart';
import 'package:mobile/features/search/presentation/screens/search_screen.dart';
import 'package:mobile/features/categories/domain/usecases/list_categories_usecase.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';
import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({Key? key}) : super(key: key);

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  late final HomeBloc _homeBloc;
  late final int _branchId;

  @override
  void initState() {
    super.initState();
    _branchId = context.read<SelectedRestaurantCubit>().state!;
    _homeBloc = HomeBloc(context.read<GetHomeDataUseCase>())
      ..add(LoadHomeData(restaurantId: _branchId));
  }

  @override
  void dispose() {
    _homeBloc.close();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final screens = [
      BlocProvider.value(value: _homeBloc, child: const HomeScreen()),
      BlocProvider(
        create:
            (_) => SearchBloc(
              context.read<ListCategoriesUseCase>(),
              context.read<ListProductsUseCase>(),
            )..add(InitSearch(_branchId)),
        child: const SearchScreen(),
      ),
      const Placeholder(), // Seat
      const Placeholder(), // Assistant
      const Placeholder(), // Activity
    ];

    return Scaffold(
      body: IndexedStack(index: _currentIndex, children: screens),
      bottomNavigationBar: PrimaryBottomNavBar(
        currentIndex: _currentIndex,
        onTap: (index) => setState(() => _currentIndex = index),
      ),
    );
  }
}
