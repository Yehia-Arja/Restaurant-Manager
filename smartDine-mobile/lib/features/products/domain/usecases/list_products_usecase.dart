import '../entities/product.dart';
import '../repositories/product_repository.dart';

class ListProductsUseCase {
  final ProductRepository repository;
  ListProductsUseCase(this.repository);

  Future<List<Product>> call({required int branchId, String? searchQuery, int? categoryId}) {
    return repository.fetchProducts(
      branchId: branchId,
      searchQuery: searchQuery,
      categoryId: categoryId,
    );
  }
}
