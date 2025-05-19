import 'package:mobile/features/favorite/data/datasources/favorite_remote.dart';
import 'package:mobile/features/favorite/domain/repositories/favorite_repository.dart';

class FavoriteRepositoryImpl extends FavoriteRepository {
  final FavoriteRemote _remote;
  FavoriteRepositoryImpl(this._remote);

  @override
  Future<void> toggleFavorite({required int id, required String type}) {
    return _remote.toggleFavorite(id: id, type: type);
  }
}
