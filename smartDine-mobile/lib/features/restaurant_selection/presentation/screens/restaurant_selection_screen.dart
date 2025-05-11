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
  bool _favoritesOnly = false;

  @override
  void initState() {
    super.initState();
    _fetchRestaurants();
  }

  void _fetchRestaurants({int page = 1}) {
    context.read<RestaurantSelectionBloc>().add(
      FetchRestaurantsRequested(
        page: page,
        query: _searchController.text,
        favoritesOnly: _favoritesOnly,
      ),
    );
  }

  void _toggleFavoritesFilter() {
    setState(() => _favoritesOnly = !_favoritesOnly);
    _fetchRestaurants();
  }

  void _onSearchChanged(String query) => _fetchRestaurants();

  Widget _buildHeader() {
    return Column(
      children: [
        const SizedBox(height: 16),
        Center(
          child: Text(
            'List of Restaurants',
            style: Theme.of(context).textTheme.headlineSmall?.copyWith(
              fontWeight: FontWeight.bold,
              color: AppColors.secondary,
            ),
          ),
        ),
        const SizedBox(height: 16),
        Padding(
          padding: const EdgeInsets.symmetric(horizontal: 16),
          child: Row(
            children: [
              Expanded(
                child: TextField(
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
                    focusedBorder: OutlineInputBorder(
                      borderRadius: BorderRadius.circular(12),
                      borderSide: const BorderSide(color: AppColors.accent),
                    ),
                  ),
                  style: Theme.of(context).textTheme.bodyMedium,
                ),
              ),
              const SizedBox(width: 8),
              IconButton(
                onPressed: _toggleFavoritesFilter,
                icon: Icon(
                  _favoritesOnly ? Icons.favorite : Icons.favorite_border,
                  color: Colors.red,
                ),
              ),
            ],
          ),
        ),
        const SizedBox(height: 16),
      ],
    );
  }

  Widget _buildBody(RestaurantSelectionState state) {
    if (state is RestaurantSelectionLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    if (state is RestaurantSelectionLoaded) {
      final restaurants = state.restaurants;

      if (restaurants.isEmpty) {
        return const Center(child: Text("No matching restaurants."));
      }

      return ListView.separated(
        padding: const EdgeInsets.symmetric(horizontal: 16),
        itemCount: restaurants.length,
        separatorBuilder: (_, __) => const SizedBox(height: 16),
        itemBuilder: (context, index) {
          return RestaurantCard(restaurant: restaurants[index]);
        },
      );
    }

    return const SizedBox();
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return BlocListener<RestaurantSelectionBloc, RestaurantSelectionState>(
      listener: (context, state) {
        if (state is RestaurantSelectionError) {
          showDialog(
            context: context,
            builder:
                (_) => AlertDialog(
                  title: const Text('Error'),
                  content: Text(state.message),
                  actions: [
                    TextButton(onPressed: () => Navigator.pop(context), child: const Text('OK')),
                  ],
                ),
          );
        }
      },
      child: BaseScaffold(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            _buildHeader(),
            Expanded(
              child: BlocBuilder<RestaurantSelectionBloc, RestaurantSelectionState>(
                builder: (context, state) => _buildBody(state),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
