import 'dart:async';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/categories/domain/usecases/list_categories_usecase.dart';
import 'package:mobile/features/products/domain/usecases/list_products_usecase.dart';

import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/screens/home_screen.dart';

import 'package:mobile/features/search/presentation/bloc/search_bloc.dart';
import 'package:mobile/features/search/presentation/bloc/search_event.dart';
import 'package:mobile/features/search/presentation/screens/search_screen.dart';

import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({Key? key}) : super(key: key);

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  late final int _restaurantId;
  int? _branchId;
  late final HomeBloc _homeBloc;
  late final SearchBloc _searchBloc;
  StreamSubscription<int?>? _branchSub;

  @override
  void initState() {
    super.initState();

    final rest = context.read<SelectedRestaurantCubit>().state;
    if (rest == null) throw Exception('No restaurant selected!');
    _restaurantId = rest;

    _branchId = context.read<SelectedBranchCubit>().state;

    _homeBloc = HomeBloc(context.read<GetHomeDataUseCase>())
      ..add(LoadHomeData(restaurantId: _restaurantId, branchId: _branchId));

    _searchBloc = SearchBloc(
      context.read<ListCategoriesUseCase>(),
      context.read<ListProductsUseCase>(),
    );
    if (_branchId != null) {
      _searchBloc.add(InitSearch(_branchId!));
    }

    _branchSub = context.read<SelectedBranchCubit>().stream.listen((newBranch) {
      if (newBranch != null && newBranch != _branchId) {
        _branchId = newBranch;
        _homeBloc.add(LoadHomeData(restaurantId: _restaurantId, branchId: _branchId));
        _searchBloc.add(InitSearch(_branchId!));
        setState(() {});
      }
    });
  }

  @override
  void dispose() {
    _branchSub?.cancel();
    _homeBloc.close();
    _searchBloc.close();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final screens = [
      BlocProvider.value(
        key: ValueKey('home_${_branchId ?? 'none'}'),
        value: _homeBloc,
        child: const HomeScreen(),
      ),
      BlocProvider.value(
        key: ValueKey('search_${_branchId ?? 'none'}'),
        value: _searchBloc,
        child: const SearchScreen(),
      ),
      const Placeholder(key: ValueKey('seat')),
      const Placeholder(key: ValueKey('assistant')),
      const Placeholder(key: ValueKey('activity')),
    ];

    return Scaffold(
      body: IndexedStack(index: _currentIndex, children: screens),
      bottomNavigationBar: PrimaryBottomNavBar(
        currentIndex: _currentIndex,
        onTap: (i) => setState(() => _currentIndex = i),
      ),
    );
  }
}
