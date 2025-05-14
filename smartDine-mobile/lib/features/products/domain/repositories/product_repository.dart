import '../entities/product.dart';

abstract class ProductRepository {
  Future<PaginatedProducts> getProducts({
    required int branchId,
    String? searchQuery,
    int? categoryId,
    bool favoritesOnly,
    int page,
    int pageSize,
  });

  Future<Product> fetchById(int productId);
}

class PaginatedProducts {
  final List<Product> products;
  final int totalPages;

  PaginatedProducts({required this.products, required this.totalPages});
}
