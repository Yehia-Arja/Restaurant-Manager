import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'package:mobile/core/blocs/selected_restaurant_cubit.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/home/presentation/bloc/home_bloc.dart';
import 'package:mobile/features/home/presentation/bloc/home_state.dart';
import 'package:mobile/features/home/presentation/widgets/branch_selector.dart';
import 'package:mobile/features/categories/presentation/widgets/category_card.dart';
import 'package:mobile/features/products/presentation/widgets/product_card.dart';
import 'package:mobile/features/products/presentation/bloc/product_bloc.dart';
import 'package:mobile/features/products/presentation/bloc/product_event.dart';

class HomeScreen extends StatelessWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final restaurantId = context.read<SelectedRestaurantCubit>().state;
    if (restaurantId == null) {
      return const SafeArea(child: Center(child: Text('Restaurant not selected.')));
    }

    return BlocBuilder<HomeBloc, HomeState>(
      builder: (ctx, state) {
        if (state is HomeLoading || state is HomeInitial) {
          return const SafeArea(child: Center(child: CircularProgressIndicator()));
        }
        if (state is HomeError) {
          return SafeArea(child: Center(child: Text(state.message)));
        }

        final data = (state as HomeLoaded).data;
        final media = MediaQuery.of(context);

        return Scaffold(
          extendBodyBehindAppBar: true,
          body: Column(
            children: [
              Container(
                padding: EdgeInsets.only(top: media.padding.top + 16, bottom: 20),
                decoration: const BoxDecoration(
                  color: AppColors.accent,
                  borderRadius: BorderRadius.only(
                    bottomLeft: Radius.circular(12),
                    bottomRight: Radius.circular(12),
                  ),
                ),
                child: BranchSelector(branches: data.branches, onNotificationTap: () {}),
              ),
              Expanded(
                child: SafeArea(
                  top: false,
                  bottom: true,
                  child: SingleChildScrollView(
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      children: [
                        if (data.categories.isNotEmpty) ...[
                          const SizedBox(height: 8),
                          _sectionHeader(context, 'Categories'),
                          const SizedBox(height: 4),
                          SizedBox(
                            height: media.size.width * (92 / 390),
                            child: ListView.separated(
                              scrollDirection: Axis.horizontal,
                              itemCount: data.categories.length,
                              separatorBuilder: (_, __) => const SizedBox(width: 12),
                              itemBuilder:
                                  (_, i) =>
                                      CategoryCard(category: data.categories[i], onTap: () {}),
                            ),
                          ),
                        ],

                        const SizedBox(height: 8),
                        _sectionHeader(context, 'Popular Food'),
                        const SizedBox(height: 4),
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
                            itemBuilder:
                                (_, i) => ProductCard(
                                  product: data.products[i],
                                  onFavoritePressed: () {
                                    print("❤️ Favorite pressed: ${data.products[i].id}");
                                    context.read<ProductBloc>().add(
                                      ToggleProductFavorite(data.products[i].id),
                                    );
                                  },
                                ),
                          ),
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
    );
  }

  Widget _sectionHeader(BuildContext context, String title) {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 20),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Flexible(
            child: Text(
              title,
              style: Theme.of(context).textTheme.headlineMedium,
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
          ),
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
