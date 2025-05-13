import '../entities/product.dart';
import '../repositories/product_repository.dart';

class ListProductsUseCase {
  final ProductRepository repository;
  ListProductsUseCase(this.repository);

  Future<List<Product>> call(int branchId) {
    return repository.fetchProducts(branchId: branchId);
  }
}
