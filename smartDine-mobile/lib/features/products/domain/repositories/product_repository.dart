import '../entities/product.dart';

abstract class ProductRepository {
  Future<List<Product>> fetchProducts({
    required int branchId,
    String? searchQuery,
    int? categoryId,
  });

  Future<Product> fetchById(int productId);
}
