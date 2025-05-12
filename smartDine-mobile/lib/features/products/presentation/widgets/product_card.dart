import 'package:flutter/material.dart';
import 'package:mobile/core/theme/colors.dart';
import 'package:mobile/features/products/domain/entities/product.dart';
import 'package:mobile/features/products/presentation/widgets/product_detail_card.dart';

class ProductCard extends StatelessWidget {
  final Product product;
  final VoidCallback? onTap;

  const ProductCard({super.key, required this.product, this.onTap});

  @override
  Widget build(BuildContext context) {
    return AspectRatio(
      aspectRatio: 167 / 220,
      child: ClipRRect(
        borderRadius: BorderRadius.circular(12),
        child: Material(
          color: Colors.white,
          elevation: 2,
          child: InkWell(
            onTap:
                onTap ??
                () {
                  Navigator.of(context).push(
                    MaterialPageRoute(builder: (_) => ProductDetailPage(productId: product.id)),
                  );
                },
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              children: [
                // IMAGE
                Expanded(
                  child: Container(
                    color: AppColors.placeholder,
                    child: const Center(child: Icon(Icons.image, size: 32, color: Colors.white54)),
                  ),
                ),

                // INFO
                Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 8).copyWith(bottom: 12),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      // Row 1: Title + Arrow
                      Row(
                        children: [
                          Expanded(
                            child: Text(
                              product.name,
                              maxLines: 1,
                              overflow: TextOverflow.ellipsis,
                              style: Theme.of(context).textTheme.bodySmall?.copyWith(
                                fontSize: 12,
                                fontWeight: FontWeight.normal,
                                color: AppColors.secondary,
                              ),
                            ),
                          ),
                          const SizedBox(width: 4),
                          Padding(
                            padding: const EdgeInsets.only(top: 30),
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

                      // Row 2: Time, Price
                      Row(
                        children: [
                          const Icon(Icons.access_time, size: 12, color: AppColors.accent),
                          const SizedBox(width: 4),
                          Text(
                            product.timeToDeliver,
                            style: Theme.of(context).textTheme.bodySmall?.copyWith(
                              fontSize: 10,
                              color: AppColors.placeholder,
                            ),
                          ),
                          const SizedBox(width: 8),
                          Text(
                            '•',
                            style: Theme.of(context).textTheme.bodySmall?.copyWith(
                              fontSize: 10,
                              color: AppColors.placeholder,
                            ),
                          ),
                          const SizedBox(width: 8),
                          Text(
                            product.price,
                            style: Theme.of(context).textTheme.bodySmall?.copyWith(
                              fontSize: 10,
                              color: AppColors.placeholder,
                            ),
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
    );
  }
}
