import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/bloc/home_state.dart';
import 'package:mobile/features/home/presentation/widgets/branch_selector.dart';
import 'package:mobile/features/categories/presentation/widgets/category_card.dart';
import 'package:mobile/features/products/presentation/widgets/product_card.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  @override
  Widget build(BuildContext context) {
    final restaurantId = context.read<SelectedRestaurantCubit>().state;
    if (restaurantId == null) {
      return const SafeArea(child: Center(child: Text('Restaurant not selected.')));
    }

    return BlocProvider(
      create:
          (_) =>
              HomeBloc(context.read<GetHomeDataUseCase>())
                ..add(LoadHomeData(restaurantId: restaurantId)),
      child: BlocBuilder<HomeBloc, HomeState>(
        builder: (context, state) {
          if (state is HomeLoading || state is HomeInitial) {
            return const SafeArea(child: Center(child: CircularProgressIndicator()));
          }
          if (state is HomeError) {
            return SafeArea(child: Center(child: Text(state.message)));
          }

          final data = (state as HomeLoaded).data;

          return SafeArea(
            child: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  // Branch selector
                  Container(
                    color: AppColors.accent,
                    padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 8),
                    child: BranchSelector(branches: data.branches, onNotificationTap: () {}),
                  ),

                  const SizedBox(height: 12),

                  // Categories
                  if (data.categories.isNotEmpty) ...[
                    _sectionHeader(context, 'Categories'),
                    const SizedBox(height: 8),
                    SizedBox(
                      height: MediaQuery.of(context).size.width * (92 / 390),
                      child: ListView.separated(
                        scrollDirection: Axis.horizontal,
                        itemCount: data.categories.length,
                        separatorBuilder: (_, __) => const SizedBox(width: 12),
                        itemBuilder:
                            (_, i) => CategoryCard(category: data.categories[i], onTap: () {}),
                      ),
                    ),
                    const SizedBox(height: 12),
                  ],

                  // Popular Food
                  _sectionHeader(context, 'Popular Food'),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20),
                    child: GridView.builder(
                      shrinkWrap: true,
                      physics: const NeverScrollableScrollPhysics(),
                      itemCount: data.products.length,
                      gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                        crossAxisCount: 2,
                        mainAxisSpacing: 12,
                        crossAxisSpacing: 12,
                        childAspectRatio: 167 / 193,
                      ),
                      itemBuilder: (_, i) => ProductCard(product: data.products[i]),
                    ),
                  ),

                  const SizedBox(height: 20),
                ],
              ),
            ),
          );
        },
      ),
    );
  }

  Widget _sectionHeader(BuildContext context, String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(title, style: Theme.of(context).textTheme.headlineMedium),
          TextButton(
            onPressed: () {},
            style: TextButton.styleFrom(foregroundColor: AppColors.accent),
            child: const Text('View all'),
          ),
        ],
      ),
    );
  }
}
