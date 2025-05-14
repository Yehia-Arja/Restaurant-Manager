import 'package:equatable/equatable.dart';
import 'package:mobile/features/categories/domain/entities/category.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

class SearchState extends Equatable {
  final List<Category> categories;
  final List<Product> products;
  final bool loadingCats;
  final bool loadingProds;
  final bool hasMore;
  final int page;
  final int? selectedCategory;
  final String query;
  final String? error;

  const SearchState({
    this.categories = const [],
    this.products = const [],
    this.loadingCats = false,
    this.loadingProds = false,
    this.hasMore = true,
    this.page = 1,
    this.selectedCategory,
    this.query = '',
    this.error,
  });

  SearchState copyWith({
    List<Category>? categories,
    List<Product>? products,
    bool? loadingCats,
    bool? loadingProds,
    bool? hasMore,
    int? page,
    int? selectedCategory,
    String? query,
    String? error,
  }) {
    return SearchState(
      categories: categories ?? this.categories,
      products: products ?? this.products,
      loadingCats: loadingCats ?? this.loadingCats,
      loadingProds: loadingProds ?? this.loadingProds,
      hasMore: hasMore ?? this.hasMore,
      page: page ?? this.page,
      selectedCategory: selectedCategory,
      query: query ?? this.query,
      error: error,
    );
  }

  @override
  List<Object?> get props => [
    categories,
    products,
    loadingCats,
    loadingProds,
    hasMore,
    page,
    selectedCategory,
    query,
    error,
  ];
}
