import '../repositories/product_repository.dart';

class ListProductsUseCase {
  final ProductRepository repository;
  ListProductsUseCase(this.repository);

  Future<PaginatedProducts> call({
    required int branchId,
    String? searchQuery,
    int? categoryId,
    bool favoritesOnly = false,
    int page = 1,
    int pageSize = 10,
  }) {
    return repository.getProducts(
      branchId: branchId,
      searchQuery: searchQuery,
      categoryId: categoryId,
      favoritesOnly: favoritesOnly,
      page: page,
      pageSize: pageSize,
    );
  }
}
