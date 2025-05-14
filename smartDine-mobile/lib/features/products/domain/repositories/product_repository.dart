import '../entities/product.dart';

abstract class ProductRepository {
  Future<PaginatedProducts> getProducts({
    int? categoryId,
    String? searchQuery,
    bool favoritesOnly = false,
    int page = 1,
    int pageSize = 10,
  });

  Future<Product> fetchById(int productId);
}

class PaginatedProducts {
  final List<Product> products;
  final int totalPages;

  PaginatedProducts({required this.products, required this.totalPages});
}
