import 'package:mobile/features/favorite/domain/repositories/favorite_repository.dart';

class ToggleFavoriteUseCase {
  final FavoriteRepository _repo;
  ToggleFavoriteUseCase(this._repo);

  Future<void> call({required int id, required String type}) {
    return _repo.toggleFavorite(id: id, type: type);
  }
}
