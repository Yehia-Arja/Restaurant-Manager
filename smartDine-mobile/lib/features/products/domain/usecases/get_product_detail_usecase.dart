import 'package:mobile/features/products/domain/entities/product.dart';
import 'package:mobile/features/products/domain/repositories/product_repository.dart';

class GetProductDetailUseCase {
  final ProductRepository _repo;
  GetProductDetailUseCase(this._repo);
  Future<Product> call(int id) => _repo.fetchById(id);
}
