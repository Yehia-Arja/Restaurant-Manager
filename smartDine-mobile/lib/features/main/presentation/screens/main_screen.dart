import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/screens/home_screen.dart';
import 'package:mobile/features/search/presentation/screens/search_screen.dart';
import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';

class MainScreen extends StatefulWidget {
  const MainScreen({Key? key}) : super(key: key);

  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  late final HomeBloc _homeBloc;
  late final List<Widget> _screens;

  @override
  void initState() {
    super.initState();
    // Initialize HomeBloc once, with the selected restaurant ID
    final restaurantId = context.read<SelectedRestaurantCubit>().state;
    _homeBloc = HomeBloc(context.read<GetHomeDataUseCase>())
      ..add(LoadHomeData(restaurantId: restaurantId!));

    _screens = [
      BlocProvider.value(value: _homeBloc, child: const HomeScreen()),
      const SearchScreen(),
      const Placeholder(), // Seat
      const Placeholder(), // Assistant
      const Placeholder(), // Activity
    ];
  }

  @override
  void dispose() {
    _homeBloc.close();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: IndexedStack(index: _currentIndex, children: _screens),
      bottomNavigationBar: PrimaryBottomNavBar(
        currentIndex: _currentIndex,
        onTap: (index) => setState(() => _currentIndex = index),
      ),
    );
  }
}
