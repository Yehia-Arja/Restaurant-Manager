import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/products/domain/entities/product.dart';
import 'package:mobile/features/products/presentation/widgets/product_detail_page.dart';

class ProductCard extends StatelessWidget {
  final Product product;
  final VoidCallback? onTap;
  final VoidCallback? onFavoritePressed;

  const ProductCard({super.key, required this.product, this.onTap, this.onFavoritePressed});

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final cardWidth = (screenWidth - 64) / 2;
    final cardHeight = cardWidth * 1.3;

    return SizedBox(
      width: cardWidth,
      height: cardHeight,
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: Material(
          color: Colors.white,
          elevation: 2,
          child: InkWell(
            onTap: () {
              if (onTap != null) {
                onTap!();
              } else {
                Navigator.of(context).push(
                  MaterialPageRoute(
                    builder:
                        (_) => ProductDetailPage(initialProduct: product, productId: product.id),
                  ),
                );
              }
            },
            child: Container(
              decoration: BoxDecoration(
                border: Border.all(color: AppColors.border),
                borderRadius: BorderRadius.circular(12),
              ),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  Expanded(
                    child: Stack(
                      children: [
                        Container(
                          decoration: const BoxDecoration(
                            color: AppColors.placeholder,
                            borderRadius: BorderRadius.vertical(top: Radius.circular(12)),
                          ),
                          child: const Center(
                            child: Icon(Icons.image, size: 32, color: Colors.white54),
                          ),
                        ),
                        Positioned(
                          top: 8,
                          right: 8,
                          child: GestureDetector(
                            onTap: () {
                              if (onFavoritePressed != null) {
                                onFavoritePressed!();
                              }
                            },
                            child: Container(
                              width: 28,
                              height: 28,
                              decoration: BoxDecoration(
                                shape: BoxShape.circle,
                                color: Colors.white,
                                boxShadow: [
                                  BoxShadow(
                                    color: Colors.black.withOpacity(0.1),
                                    blurRadius: 4,
                                    offset: Offset(0, 2),
                                  ),
                                ],
                              ),
                              child: Icon(
                                Icons.favorite,
                                size: 18,
                                color: product.isFavorited ? Colors.red : Colors.grey.shade400,
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                  Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 8).copyWith(bottom: 12, top: 8),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Row(
                          children: [
                            Expanded(
                              child: Text(
                                product.name,
                                maxLines: 1,
                                overflow: TextOverflow.ellipsis,
                                style: Theme.of(context).textTheme.bodySmall?.copyWith(
                                  fontSize: 14,
                                  color: AppColors.secondary,
                                ),
                              ),
                            ),
                            const SizedBox(width: 4),
                            Padding(
                              padding: const EdgeInsets.only(top: 24),
                              child: Container(
                                width: 24,
                                height: 24,
                                decoration: const BoxDecoration(
                                  shape: BoxShape.circle,
                                  color: AppColors.accent,
                                ),
                                child: const Icon(
                                  Icons.north_east,
                                  size: 14,
                                  color: AppColors.primary,
                                ),
                              ),
                            ),
                          ],
                        ),
                        const SizedBox(height: 8),
                        Row(
                          children: [
                            const Icon(Icons.access_time, size: 12, color: AppColors.accent),
                            const SizedBox(width: 4),
                            Text(
                              product.timeToDeliver,
                              style: Theme.of(
                                context,
                              ).textTheme.bodySmall?.copyWith(fontSize: 12, color: AppColors.label),
                            ),
                            const SizedBox(width: 8),
                            const Icon(Icons.brightness_1, size: 4, color: AppColors.label),
                            const SizedBox(width: 8),
                            Text(
                              product.price,
                              style: Theme.of(
                                context,
                              ).textTheme.bodySmall?.copyWith(fontSize: 12, color: AppColors.label),
                            ),
                          ],
                        ),
                      ],
                    ),
                  ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
