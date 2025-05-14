import '../../domain/entities/product.dart';
import '../../domain/entities/paginated_products.dart';
import '../../domain/repositories/product_repository.dart';
import '../datasources/product_remote.dart';

class ProductRepositoryImpl implements ProductRepository {
  final ProductRemote _remote;
  ProductRepositoryImpl(this._remote);

  @override
  Future<PaginatedProducts> getProducts({
    String? searchQuery,
    int? categoryId,
    bool favoritesOnly = false,
    int page = 1,
    int pageSize = 10,
  }) {
    return _remote.fetchProducts(
      searchQuery: searchQuery,
      categoryId: categoryId,
      favoritesOnly: favoritesOnly,
      page: page,
      pageSize: pageSize,
    );
  }

  @override
  Future<Product> fetchById(int productId) {
    return _remote.fetchProductById(productId);
  }
}
