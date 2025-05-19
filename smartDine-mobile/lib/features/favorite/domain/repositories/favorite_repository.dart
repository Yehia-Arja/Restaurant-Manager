abstract class FavoriteRepository {
  Future<void> toggleFavorite({required int id, required String type});
}
