import 'package:equatable/equatable.dart';
import 'package:mobile/features/categories/domain/entities/category.dart';
import 'package:mobile/features/products/domain/entities/product.dart';

class SearchState extends Equatable {
  final int? branchId;
  final List<Category> categories;
  final List<Product> products;
  final bool loadingCats;
  final bool loadingProds;
  final int totalPages;
  final int page;
  final int? selectedCategory;
  final String query;
  final String? error;

  const SearchState({
    this.branchId,
    this.categories = const [],
    this.products = const [],
    this.loadingCats = false,
    this.loadingProds = false,
    this.totalPages = 1,
    this.page = 1,
    this.selectedCategory,
    this.query = '',
    this.error,
  });

  bool get hasMore => page < totalPages;

  SearchState copyWith({
    int? branchId,
    List<Category>? categories,
    List<Product>? products,
    bool? loadingCats,
    bool? loadingProds,
    int? totalPages,
    int? page,
    int? selectedCategory,
    String? query,
    String? error,
  }) {
    return SearchState(
      branchId: branchId ?? this.branchId,
      categories: categories ?? this.categories,
      products: products ?? this.products,
      loadingCats: loadingCats ?? this.loadingCats,
      loadingProds: loadingProds ?? this.loadingProds,
      totalPages: totalPages ?? this.totalPages,
      page: page ?? this.page,
      selectedCategory: selectedCategory,
      query: query ?? this.query,
      error: error,
    );
  }

  @override
  List<Object?> get props => [
    branchId,
    categories,
    products,
    loadingCats,
    loadingProds,
    totalPages,
    page,
    selectedCategory,
    query,
    error,
  ];
}
