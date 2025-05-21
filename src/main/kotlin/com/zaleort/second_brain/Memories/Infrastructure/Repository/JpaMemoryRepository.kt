package com.zaleort.second_brain.Memories.Infrastructure.Repository

import org.springframework.data.jpa.repository.JpaRepository
import java.util.UUID

interface JpaMemoryRepository : JpaRepository<MemoryEntity, String> {
    fun findByUserId(userId: UUID): List<MemoryEntity>
}