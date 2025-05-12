import '../../domain/entities/product.dart';
import '../../domain/repositories/product_repository.dart';
import '../datasources/product_remote.dart';

class ProductRepositoryImpl implements ProductRepository {
  final ProductRemote _remote;
  ProductRepositoryImpl(this._remote);

  @override
  Future<List<Product>> fetchProducts({required int branchId}) {
    return _remote.fetchProducts(branchId);
  }
}
