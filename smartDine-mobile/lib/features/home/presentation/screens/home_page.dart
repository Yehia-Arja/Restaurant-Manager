import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_event.dart';
import 'package:mobile/features/home/presentation/bloc/home_state.dart';
import 'package:mobile/features/home/presentation/widgets/branch_selector.dart';
import 'package:mobile/features/categories/presentation/widgets/category_card.dart';
import 'package:mobile/features/products/presentation/widgets/product_card.dart';
import 'package:mobile/shared/widgets/bottom_navigation_bar.dart';
import 'package:mobile/features/home/domain/usecases/get_home_data_usecase.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});
  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _navIndex = 0;

  @override
  Widget build(BuildContext context) {
    final restaurantId = context.read<SelectedRestaurantCubit>().state;

    if (restaurantId == null) {
      return Scaffold(
        body: const Center(child: Text('Restaurant not selected.')),
        bottomNavigationBar: _navBar,
      );
    }

    return BlocProvider(
      create:
          (_) =>
              HomeBloc(context.read<GetHomeDataUseCase>())
                ..add(LoadHomeData(restaurantId: restaurantId)),
      child: MultiBlocListener(
        listeners: [
          BlocListener<HomeBloc, HomeState>(
            listener: (c, s) {
              if (s is HomeLoaded) c.read<SelectedBranchCubit>().select(s.data.selectedBranch.id);
            },
          ),
          BlocListener<SelectedBranchCubit, int?>(
            listener: (c, bid) {
              if (bid != null) {
                final rid = context.read<SelectedRestaurantCubit>().state;
                if (rid != null) {
                  c.read<HomeBloc>().add(LoadHomeData(restaurantId: rid, branchId: bid));
                }
              }
            },
          ),
        ],
        child: BlocBuilder<HomeBloc, HomeState>(
          builder: (c, state) {
            if (state is HomeLoading || state is HomeInitial) {
              return Scaffold(
                body: const Center(child: CircularProgressIndicator()),
                bottomNavigationBar: _navBar,
              );
            }
            if (state is HomeError) {
              return Scaffold(
                body: Center(child: Text(state.message)),
                bottomNavigationBar: _navBar,
              );
            }

            final data = (state as HomeLoaded).data;
            final statusBar = MediaQuery.of(context).padding.top;

            return Scaffold(
              bottomNavigationBar: _navBar,
              body: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  ClipRRect(
                    borderRadius: const BorderRadius.vertical(bottom: Radius.circular(12)),
                    child: Container(
                      width: double.infinity,
                      color: AppColors.accent,
                      padding: EdgeInsets.fromLTRB(20, statusBar, 20, 4),
                      child: BranchSelector(branches: data.branches, onNotificationTap: () {}),
                    ),
                  ),
                  Expanded(
                    child: SingleChildScrollView(
                      padding: const EdgeInsets.only(top: 12),
                      child: Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 20),
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            if (data.categories.isNotEmpty) ...[
                              _sectionHeader(context, 'Categories'),
                              const SizedBox(height: 8),
                              SizedBox(
                                height: MediaQuery.of(context).size.width * (92 / 390),
                                child: ListView.separated(
                                  scrollDirection: Axis.horizontal,
                                  padding: EdgeInsets.zero,
                                  itemCount: data.categories.length,
                                  separatorBuilder: (_, __) => const SizedBox(width: 12),
                                  itemBuilder:
                                      (_, i) =>
                                          CategoryCard(category: data.categories[i], onTap: () {}),
                                ),
                              ),
                              const SizedBox(height: 12),
                            ],
                            _sectionHeader(context, 'Popular Food'),
                            GridView.builder(
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
                            const SizedBox(height: 20),
                          ],
                        ),
                      ),
                    ),
                  ),
                ],
              ),
            );
          },
        ),
      ),
    );
  }

  PrimaryBottomNavBar get _navBar =>
      PrimaryBottomNavBar(currentIndex: _navIndex, onTap: (i) => setState(() => _navIndex = i));

  Row _sectionHeader(BuildContext ctx, String title) => Row(
    mainAxisAlignment: MainAxisAlignment.spaceBetween,
    children: [
      Text(title, style: Theme.of(ctx).textTheme.headlineMedium),
      TextButton(
        onPressed: () {},
        style: TextButton.styleFrom(foregroundColor: AppColors.accent),
        child: const Text('View all'),
      ),
    ],
  );
}
