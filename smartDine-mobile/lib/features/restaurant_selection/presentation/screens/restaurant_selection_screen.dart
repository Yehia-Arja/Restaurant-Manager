import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/features/restaurant_selection/presentation/bloc/restaurant_selection_bloc.dart';
import 'package:mobile/features/restaurant_selection/presentation/bloc/restaurant_selection_event.dart';
import 'package:mobile/features/restaurant_selection/presentation/bloc/restaurant_selection_state.dart';
import 'package:mobile/features/restaurant_selection/presentation/widgets/restaurant_card.dart';

class RestaurantSelectionScreen extends StatefulWidget {
  const RestaurantSelectionScreen({super.key});

  @override
  State<RestaurantSelectionScreen> createState() => _RestaurantSelectionScreenState();
}

class _RestaurantSelectionScreenState extends State<RestaurantSelectionScreen> {
  final TextEditingController _searchController = TextEditingController();
  List _allRestaurants = [];

  @override
  void initState() {
    super.initState();
    context.read<RestaurantSelectionBloc>().add(FetchRestaurantsRequested());
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  void _onSearchChanged(String query) {
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    return BaseScaffold(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const SizedBox(height: 16),
          Text(
            'List of restaurants',
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
              fontWeight: FontWeight.bold,
              color: AppColors.secondary,
            ),
          ),
          const SizedBox(height: 16),

          // Search bar
          TextField(
            controller: _searchController,
            onChanged: _onSearchChanged,
            decoration: InputDecoration(
              hintText: 'Search restaurants...',
              prefixIcon: const Icon(Icons.search, color: AppColors.placeholder),
              filled: true,
              fillColor: AppColors.primary,
              contentPadding: const EdgeInsets.symmetric(vertical: 14, horizontal: 16),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
                borderSide: const BorderSide(color: AppColors.border),
              ),
              enabledBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
                borderSide: const BorderSide(color: AppColors.border),
              ),
              focusedBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
                borderSide: const BorderSide(color: AppColors.accent),
              ),
            ),
            style: Theme.of(context).textTheme.bodyMedium,
          ),
          const SizedBox(height: 16),

          Expanded(
            child: BlocBuilder<RestaurantSelectionBloc, RestaurantSelectionState>(
              builder: (context, state) {
                if (state is RestaurantSelectionLoading) {
                  return const Center(child: CircularProgressIndicator());
                } else if (state is RestaurantSelectionError) {
                  return Center(child: Text(state.message));
                } else if (state is RestaurantSelectionLoaded) {
                  _allRestaurants = state.restaurants;

                  final filtered =
                      _searchController.text.isEmpty
                          ? _allRestaurants
                          : _allRestaurants
                              .where(
                                (r) => r.name.toLowerCase().contains(
                                  _searchController.text.toLowerCase(),
                                ),
                              )
                              .toList();

                  if (filtered.isEmpty) {
                    return const Center(child: Text("No matching restaurants."));
                  }

                  return ListView.separated(
                    itemCount: filtered.length,
                    separatorBuilder: (_, __) => const SizedBox(height: 16),
                    itemBuilder: (context, index) {
                      return RestaurantCard(
                        restaurant: filtered[index],
                        onFavoritePressed: () {
                          // TODO: Implement favorite toggle
                        },
                      );
                    },
                  );
                } else {
                  return const SizedBox(); // Initial state
                }
              },
            ),
          ),
        ],
      ),
    );
  }
}
