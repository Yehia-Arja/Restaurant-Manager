import '../entities/product.dart';

abstract class ProductRepository {
  Future<List<Product>> fetchProducts({required int branchId});

  Future<Product> fetchById(int productId);
}
