import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:mobile/features/search/presentation/bloc/search_bloc.dart';
import 'package:mobile/features/search/presentation/bloc/search_event.dart';
import 'package:mobile/features/search/presentation/bloc/search_state.dart';
import 'package:mobile/features/categories/presentation/widgets/category_chip.dart';
import 'package:mobile/shared/widgets/base_scaffold.dart';
import 'package:mobile/core/blocs/selected_branch_cubit.dart';
import 'package:mobile/features/products/presentation/widgets/product_card.dart';

class SearchScreen extends StatefulWidget {
  const SearchScreen({super.key});

  @override
  State<SearchScreen> createState() => _SearchScreenState();
}

class _SearchScreenState extends State<SearchScreen> {
  final _scroll = ScrollController();
  bool showFavoritesOnly = false;

  @override
  void initState() {
    super.initState();
    final branchId = context.read<SelectedBranchCubit>().state;
    if (branchId != null) {
      context.read<SearchBloc>().add(InitSearch(branchId));
    }

    _scroll.addListener(() {
      final bloc = context.read<SearchBloc>();
      if (_scroll.position.pixels >= _scroll.position.maxScrollExtent - 100 &&
          bloc.state.hasMore &&
          !bloc.state.loadingProds) {
        bloc.add(FetchMoreProducts());
      }
    });
  }

  void _toggleFavorites() {
    setState(() {
      showFavoritesOnly = !showFavoritesOnly;
    });

    final bloc = context.read<SearchBloc>();
    bloc.add(QueryChanged(bloc.state.query, favoritesOnly: showFavoritesOnly));
  }

  @override
  Widget build(BuildContext context) {
    return BaseScaffold(
      child: BlocBuilder<SearchBloc, SearchState>(
        builder: (context, state) {
          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Row(
                children: [
                  Text('Search', style: Theme.of(context).textTheme.headlineMedium),
                  const Spacer(),
                  IconButton(
                    onPressed: _toggleFavorites,
                    icon: Icon(
                      showFavoritesOnly ? Icons.favorite : Icons.favorite_border,
                      color: Colors.red,
                    ),
                  ),
                ],
              ),
              const SizedBox(height: 12),
              TextField(
                onChanged: (q) {
                  context.read<SearchBloc>().add(QueryChanged(q, favoritesOnly: showFavoritesOnly));
                },
                decoration: InputDecoration(
                  hintText: 'Search...',
                  prefixIcon: const Icon(Icons.search),
                  filled: true,
                  fillColor: const Color(0xFFF4F4F4),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(12),
                    borderSide: BorderSide.none,
                  ),
                ),
              ),
              const SizedBox(height: 16),
              SizedBox(
                height: 40,
                child: ListView.builder(
                  scrollDirection: Axis.horizontal,
                  itemCount: state.categories.length + 1,
                  itemBuilder: (ctx, i) {
                    if (i == 0) {
                      return CategoryChip(
                        key: const ValueKey('all'), // Changed to constant key
                        label: "All",
                        selected: state.selectedCategory == null,
                        onTap: () => context.read<SearchBloc>().add(CategoryChanged(null)),
                      );
                    }
                    final cat = state.categories[i - 1];
                    return CategoryChip(
                      key: ValueKey('category-${cat.id}'), // Added prefix to key
                      label: cat.name,
                      selected: state.selectedCategory == cat.id,
                      onTap: () => context.read<SearchBloc>().add(CategoryChanged(cat.id)),
                    );
                  },
                ),
              ),
              const SizedBox(height: 16),
              Expanded(
                child:
                    state.loadingProds && state.products.isEmpty
                        ? const Center(child: CircularProgressIndicator())
                        : GridView.builder(
                          controller: _scroll,
                          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                            crossAxisCount: 2,
                            crossAxisSpacing: 12,
                            mainAxisSpacing: 12,
                            childAspectRatio: 167 / 193,
                          ),
                          itemCount:
                              state.products.length + (state.loadingProds && state.hasMore ? 1 : 0),
                          itemBuilder: (ctx, i) {
                            if (i >= state.products.length) {
                              return const Center(child: CircularProgressIndicator());
                            }
                            final product = state.products[i];
                            return ProductCard(
                              product: product,
                              onFavoritePressed: () {
                                context.read<SearchBloc>().add(
                                  ToggleSearchProductFavorite(product.id),
                                );
                              },
                            );
                          },
                        ),
              ),
            ],
          );
        },
      ),
    );
  }
}
